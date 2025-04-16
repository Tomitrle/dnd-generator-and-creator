<?php

/**
 * Sources:
 * https://stackoverflow.com/questions/4064444/returning-json-from-a-php-script
 * https://www.php.net/manual/en/function.uasort.php
 */

class MonsterAPIController extends BaseController
{
  /**
   * This regular expression is used for input validation.
   * Allows all word characters, whitespace characters, and a select handful of symbols.
   * Hopefully, this should help prevent SQL injection.
   */
  const REGEX = "/\A[\w\s\-\?\,\.\!\&\(\)]+\z/";

  // MARK: RUN
  public function run(): void
  {
    if (!$this->isAuthenticated())
      $this->errorResponse(401, "You must be logged in to interact with this resource.");

    if (!isset($_GET["command"]))
      $_GET["command"] = "";

    switch ($_GET["command"]) {
      case "create":
        if (!empty($_GET["monster_id"]))
          $this->errorResponse(400, "Attempted to create a resource that already exists.");
        if (!$_SERVER["REQUEST_METHOD"] === "POST")
          $this->errorResponse(400, "This operation requires that variables are sent via POST");

        $monster_id = $this->createMonster($_POST);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["monster_id" => $monster_id]);
        exit();
        break;

      case "update":
        if (empty($_GET["monster_id"]))
          $this->errorResponse(400, "A 'monster_id' is required.");
        if (!$_SERVER["REQUEST_METHOD"] === "POST")
          $this->errorResponse(400, "This operation requires that variables are sent via POST");

        $this->updateMonster($_GET["monster_id"], $_POST);
        return;

      case "delete":
        if (empty($_GET["monster_id"]))
          $this->errorResponse(400, "A 'monster_id' is required.");

        $this->deleteMonster($_GET["monster_id"]);
        return;

      // VIEW THE REQUESTED MONSTER
      case "view":
      default:
        if (empty($_GET["monster_id"]))
          $this->errorResponse(400, "A 'monster_id' is required.");

        if (!isset($_GET["format"]))
          $_GET["format"] = "";

        switch ($_GET["format"]) {
          case "json":
          default:
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->getMonsterAsArray($_GET["monster_id"]));
            exit();
        }
    }
  }

  // MARK: PERMISSIONS
  // Checks whether the given monster is owned by the given user.
  public function checkPermissions(int $monsterID): bool
  {
    if (!$this->isAuthenticated())
      $this->errorResponse(401, "You must be logged in to interact with this resource.");

    $result = $this->database->query(
      "SELECT * FROM dnd_monsters WHERE (id, user_id) = ($1, $2);",
      $monsterID,
      $_SESSION["user_id"],
    );

    return !empty($result);
  }

  /**
   * MARK: VALIDATION
   * Checks whether the form inputs are valid.
   * Returns true on success and an error message on failure.
   */
  protected function formValidation(array $VARIABLES): array | string
  {
    $fieldOptions = json_decode(file_get_contents("{$GLOBALS['src']}/data/monster-options.json"), true);

    $requiredFields = [
      "regex" => [
        "name" => self::REGEX,
      ],

      "options" => [
        "size" => $fieldOptions["size"],
        "type" => $fieldOptions["type"],
        "alignment" => $fieldOptions["alignment"],
        "armor" => array_column($fieldOptions["armor"], "name")
      ],

      "range" => [
        "armor_class" => [0, 30, 1],
        "hit_dice" => [0, 1000, 1],
        "health" => [0, 1000, 1],

        "strength_score" => [1, 30, 1],
        "dexterity_score" => [1, 30, 1],
        "constitution_score" => [1, 30, 1],
        "intelligence_score" => [1, 30, 1],
        "wisdom_score" => [1, 30, 1],
        "charisma_score" => [1, 30, 1],

        "strength_modifier" => [-5, 10, 1],
        "dexterity_modifier" => [-5, 10, 1],
        "constitution_modifier" => [-5, 10, 1],
        "intelligence_modifier" => [-5, 10, 1],
        "wisdom_modifier" => [-5, 10, 1],
        "charisma_modifier" => [-5, 10, 1],
      ],

      "boolean" => [],
    ];

    $optionalFields = [
      "regex" => [],

      "options" => [
        "challengeRadio" => ["estimated", "custom"],
      ],

      "range" => [
        "telepathy" => [0, 1000, 5],
        "challengeRatingSelect" => [0, 30, 1, ["1/8", "1/4", "1/2"]],
        "estimatedChallengeRating" => [0, 30, 1, ["1/8", "1/4", "1/2"]],
      ],

      "boolean" => [
        "shield" => null,

        "strength_saving_throw" => null,
        "dexterity_saving_throw" => null,
        "constitution_saving_throw" => null,
        "intelligence_saving_throw" => null,
        "wisdom_saving_throw" => null,
        "charisma_saving_throw" => null,

        "blind" => null,
      ],
    ];

    $attributeFields = [
      "regex" => [
        "name" => self::REGEX,
        "description" => self::REGEX,
      ],

      "options" => [],

      "range" => [
        "range" => [0, 1000, 5],
        "benefit" => [-1, 2, 1],
      ],

      "boolean" => [],
    ];

    /**
     * Values are checked in one of four ways: regex, options, boolean, or range.
     * The fields for each validation type are stored as associative arrays (field => constraints).
     * Each validation type checks for different constraints:
     * - 'regex' values perform a regular expression match
     * - 'options' values are compared against a list of choices
     * - 'boolean' values must be true if required
     * - 'range' values must be in the range of START(0), END(1), STEP(2) inclusive or in OTHER(3)
     * Additionally, optional fields without a value are set to NULL.
     * Note that "0" and false are not considered empty values while "" is.
     */
    try {
      // REQUIRED FIELDS
      foreach ($requiredFields as $type => $fields) {
        foreach ($fields as $fieldName => $conditions) {
          if (!isset($VARIABLES[$fieldName]) || $VARIABLES[$fieldName] === "")
            return "'$fieldName' was required but not provided.";

          if ($type === 'boolean')
            $VARIABLES[$fieldName] = 'true';

          $output = $this->validate($type, $conditions, $VARIABLES[$fieldName]);
          if ($output !== true)
            return "Value for '$fieldName' is invalid: $output.";
        }
      }

      // OPTIONAL FIELDS
      foreach ($optionalFields as $type => $fields) {
        foreach ($fields as $fieldName => $conditions) {
          if ($type === 'boolean')
            $VARIABLES[$fieldName] = isset($VARIABLES[$fieldName]) ? 'true' : 'false';

          if (!isset($VARIABLES[$fieldName]) || $VARIABLES[$fieldName] === "") {
            $VARIABLES[$fieldName] = null;
            continue;
          }

          $output = $this->validate($type, $conditions, $VARIABLES[$fieldName]);
          if ($output !== true)
            return "Value for '$fieldName' is invalid: $output.";
        }
      }

      // ATTRIBUTE FIELDS
      foreach ($VARIABLES as $category => $categoryFields) {
        if (gettype($categoryFields) !== "array") continue;
        $attributeCount = count(current($categoryFields));

        foreach ($categoryFields as $fieldName => $attributes) {
          if (count($attributes) !== $attributeCount)
            return "A different number of items for each property of attribute '$category' is invalid.";

          foreach ($attributes as $index => $value) {
            foreach ($attributeFields as $type => $fields) {
              if (!in_array($fieldName, $fields)) continue;

              if ($type === 'boolean')
                $VARIABLES[$category][$fieldName][$index] = isset($value) ? 'true' : 'false';

              if (!isset($value) || $value === "")
                return "Value for '$fieldName' was not provided.";

              $output = $this->validate($type, $fields[$fieldName], $value);
              if ($output !== true)
                return "Value for attribute $category #$index's property '$fieldName' is invalid: $output.";
            }
          }
        }
      }

      // CATCH ERRORS
    } catch (ValueError) {
      return "Value Error: One of the request fields was malformed or missing.";
    }

    return $VARIABLES;
  }

  private function validate(string $type, string | array | null $conditions, mixed $value): bool | string
  {
    switch ($type) {
      case "regex":
        if (!preg_match($conditions, $value))
          return "'$value' does not match the regular expression '$conditions'";
        break;

      case "options":
        if (!in_array($value, $conditions, true))
          return "'$value' is not in the list of valid options";
        break;

      case "boolean":
        if ($value !== 'true' && $value !== 'false')
          return "'$value' must be 'true' or 'false' (DEVELOPER ERROR)";
        break;

      // INCLUSIVE RANGE (START, END, STEP, [... OTHER ACCEPTED VALUES])
      case "range":
        if (count($conditions) > 3) {
          if (in_array($value, $conditions[3]))
            return true;
        }

        if ($value < $conditions[0] || $value > $conditions[1] || ($value - $conditions[0]) % $conditions[2] > 0)
          return "'$value' is not in the accepted range";

        break;
    }

    return true;
  }

  // MARK: CREATE
  public function createMonster(array $VARIABLES): int
  {
    if (!$this->isAuthenticated())
      $this->errorResponse(401, "You must be logged in to create this resource.");

    $VARIABLES = $this->formValidation($VARIABLES);
    if (gettype($VARIABLES) === 'string')
      $this->errorResponse(400, "Your request to edit this resource was invalid or malformed. $VARIABLES");

    $monsterID = $this->database->query(
      "INSERT INTO dnd_monsters (
        user_id,
        name,
        size,
        type,
        alignment,
        armor,
        shield,
        armor_class,
        hit_dice,
        health,

        strength_score,
        dexterity_score,
        constitution_score,
        intelligence_score,
        wisdom_score,
        charisma_score,

        strength_modifier,
        dexterity_modifier,
        constitution_modifier,
        intelligence_modifier,
        wisdom_modifier,
        charisma_modifier,

        strength_saving_throw,
        dexterity_saving_throw,
        constitution_saving_throw,
        intelligence_saving_throw,
        wisdom_saving_throw,
        charisma_saving_throw,

        blind,
        telepathy,
        challenge
      ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8, $9, $10,
        $11, $12, $13, $14, $15, $16, $17, $18, $19, $20,
        $21, $22, $23, $24, $25, $26, $27, $28, $29, $30,
        $31
      ) RETURNING id;",
      $_SESSION["user_id"],
      $VARIABLES["name"],
      $VARIABLES["size"],
      $VARIABLES["type"],
      $VARIABLES["alignment"],
      $VARIABLES["armor"],
      $VARIABLES["shield"],
      $VARIABLES["armor_class"],
      $VARIABLES["hit_dice"],
      $VARIABLES["health"],

      $VARIABLES["strength_score"],
      $VARIABLES["dexterity_score"],
      $VARIABLES["constitution_score"],
      $VARIABLES["intelligence_score"],
      $VARIABLES["wisdom_score"],
      $VARIABLES["charisma_score"],

      $VARIABLES["strength_modifier"],
      $VARIABLES["dexterity_modifier"],
      $VARIABLES["constitution_modifier"],
      $VARIABLES["intelligence_modifier"],
      $VARIABLES["wisdom_modifier"],
      $VARIABLES["charisma_modifier"],

      $VARIABLES["strength_saving_throw"],
      $VARIABLES["dexterity_saving_throw"],
      $VARIABLES["constitution_saving_throw"],
      $VARIABLES["intelligence_saving_throw"],
      $VARIABLES["wisdom_saving_throw"],
      $VARIABLES["charisma_saving_throw"],

      $VARIABLES["blind"],
      $VARIABLES["telepathy"],
      $VARIABLES["challengeRadio"] === "custom" ? $VARIABLES["challengeRatingSelect"] : $VARIABLES["estimatedChallengeRating"]
    )[0]["id"];

    foreach ($VARIABLES as $category => $fields) {
      if (gettype($fields) !== "array") continue;

      $attributeCount = count(current($fields));
      for ($i = 0; $i < $attributeCount; $i++) {
        $this->database->query(
          "INSERT INTO dnd_attributes (
            monster_id,
            type,
            name,
            range,
            description,
            benefit
          ) VALUES (
            $1, $2, $3, $4, $5, $6
          );",
          $monsterID,
          $category,
          isset($fields["name"][$i]) ? $fields["name"][$i] : null,
          isset($fields["range"][$i]) ? $fields["range"][$i] : null,
          isset($fields["description"][$i]) ? $fields["description"][$i] : null,
          isset($fields["benefit"][$i]) ? $fields["benefit"][$i] : null
        );
      }
    }

    return $monsterID;
  }

  // MARK: UPDATE
  public function updateMonster(int $monsterID, array $VARIABLES): void
  {
    if (!$this->checkPermissions($_GET["monster_id"], $_SESSION["user_id"]))
      $this->errorResponse(403, "You do not have permission to access this resource.");

    $VARIABLES = $this->formValidation($VARIABLES);
    if (gettype($VARIABLES) === 'string')
      $this->errorResponse(400, "Your request to edit this resource was invalid or malformed. $VARIABLES");

    $this->database->query(
      "UPDATE dnd_monsters * SET (
        name,
        size,
        type,
        alignment,
        armor,
        shield,
        armor_class,
        hit_dice,
        health,

        strength_score,
        dexterity_score,
        constitution_score,
        intelligence_score,
        wisdom_score,
        charisma_score,

        strength_modifier,
        dexterity_modifier,
        constitution_modifier,
        intelligence_modifier,
        wisdom_modifier,
        charisma_modifier,

        strength_saving_throw,
        dexterity_saving_throw,
        constitution_saving_throw,
        intelligence_saving_throw,
        wisdom_saving_throw,
        charisma_saving_throw,

        blind,
        telepathy,
        challenge
      ) = (
        $1, $2, $3, $4, $5, $6, $7, $8, $9, $10,
        $11, $12, $13, $14, $15, $16, $17, $18, $19, $20,
        $21, $22, $23, $24, $25, $26, $27, $28, $29, $30
      ) WHERE id = $31;",
      $VARIABLES["name"],
      $VARIABLES["size"],
      $VARIABLES["type"],
      $VARIABLES["alignment"],
      $VARIABLES["armor"],
      $VARIABLES["shield"],
      $VARIABLES["armor_class"],
      $VARIABLES["hit_dice"],
      $VARIABLES["health"],

      $VARIABLES["strength_score"],
      $VARIABLES["dexterity_score"],
      $VARIABLES["constitution_score"],
      $VARIABLES["intelligence_score"],
      $VARIABLES["wisdom_score"],
      $VARIABLES["charisma_score"],

      $VARIABLES["strength_modifier"],
      $VARIABLES["dexterity_modifier"],
      $VARIABLES["constitution_modifier"],
      $VARIABLES["intelligence_modifier"],
      $VARIABLES["wisdom_modifier"],
      $VARIABLES["charisma_modifier"],

      $VARIABLES["strength_saving_throw"],
      $VARIABLES["dexterity_saving_throw"],
      $VARIABLES["constitution_saving_throw"],
      $VARIABLES["intelligence_saving_throw"],
      $VARIABLES["wisdom_saving_throw"],
      $VARIABLES["charisma_saving_throw"],

      $VARIABLES["blind"],
      $VARIABLES["telepathy"],
      $VARIABLES["challengeRadio"] === "custom" ? $VARIABLES["challengeRatingSelect"] : $VARIABLES["estimatedChallengeRating"],
      $monsterID
    );

    // Probably inefficient.
    $this->database->query(
      "DELETE FROM dnd_attributes WHERE monster_id = $1;",
      $monsterID
    );

    foreach ($VARIABLES as $category => $fields) {
      if (gettype($fields) !== "array") continue;

      $attributeCount = count(current($fields));
      for ($i = 0; $i < $attributeCount; $i++) {
        $this->database->query(
          "INSERT INTO dnd_attributes (
            monster_id,
            type,
            name,
            range,
            description,
            benefit
          ) VALUES (
            $1, $2, $3, $4, $5, $6
          );",
          $monsterID,
          $category,
          isset($fields["name"][$i]) ? $fields["name"][$i] : null,
          isset($fields["range"][$i]) ? $fields["range"][$i] : null,
          isset($fields["description"][$i]) ? $fields["description"][$i] : null,
          isset($fields["benefit"][$i]) ? $fields["benefit"][$i] : null
        );
      }
    }
  }

  // MARK: DELETE
  public function deleteMonster(int $monsterID): void
  {
    if (!$this->checkPermissions($_GET["monster_id"], $_SESSION["user_id"]))
      $this->errorResponse(403, "You do not have permission to delete this resource.");

    $this->database->query(
      "DELETE FROM dnd_monsters WHERE id = $1;",
      $monsterID
    );
  }

  // MARK: QUERY
  public function getMonsterAsArray(int $monsterID): array
  {
    if (!$this->checkPermissions($_GET["monster_id"], $_SESSION["user_id"]))
      $this->errorResponse(403, "You do not have permission to access this resource.");

    $monster = $this->database->query(
      "SELECT * FROM dnd_monsters WHERE id = $1;",
      $monsterID
    )[0];

    foreach ($monster as $key => $value) {
      if ($key === "id" || $key === "user_id") unset($monster[$key]);
    }

    $attributes = $this->database->query(
      "SELECT * FROM dnd_attributes WHERE monster_id = $1;",
      $monsterID
    );

    foreach ($attributes as $attributeKey => $attribute) {
      foreach ($attribute as $valueKey => $value) {
        if ($value === null || $valueKey === "id" || $valueKey === "monster_id") unset($attributes[$attributeKey][$valueKey]);
      }
    }

    foreach ($attributes as $attribute) {
      $type = $attribute["type"];
      unset($attribute["type"]);

      if (!key_exists($type, $monster))
        $monster[$type] = [];

      $monster[$type][] = $attribute;
    }

    return $monster;
  }

  public function getMonsters(int $userID): array
  {
    if (!$this->isAuthenticated())
      $this->errorResponse(401, "You must be logged in to access this resource.");

    $monsters = array_column(
      $this->database->query(
        "SELECT (id, name) FROM dnd_monsters WHERE user_id = $1;",
        $userID
      ),
      "row"
    );

    foreach (array_keys($monsters) as $i) {
      $monsters[$i] = explode(",", trim($monsters[$i], "()"));
      foreach (array_keys($monsters[$i]) as $j) {
        $monsters[$i][$j] = trim($monsters[$i][$j], "\"");
      }
    }

    uasort($monsters, function ($a, $b) {
      if ($a[0] == $b[0]) return 0;
      return $a[0] < $b[0] ? -1 : 1;
    });

    return $monsters;
  }
}
