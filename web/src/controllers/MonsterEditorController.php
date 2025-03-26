<?php

/**
 * Sources:
 * https://stackoverflow.com/questions/7605480/str-replace-for-multiple-items
 */

class MonsterEditorController extends BaseController
{
  /**
   * This regular expression is used for input validation.
   * Allows all word characters, whitespace characters, and a select handful of symbols.
   * Hopefully, this should help prevent SQL injection.
   */
  const REGEX = "/\A[\w\s\-\?\,\.\!\&\(\)]+\z/";

  public function run(): void
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        switch (empty($_GET["databaseID"])) {
          case false:
            if (!$this->isAuthenticated())
              $this->errorResponse(401, "You must be logged in to edit this resource.");

            if (!$this->checkPermissions($_GET["databaseID"], $_SESSION["userID"]))
              $this->errorResponse(403, "You do not have permission to edit this resource.");

            // MARK: TODO
            // Populate fields with PHP requires
            // Make sure "databaseID" is added as a hidden input

            //             $monster = $this->database->query(
            //               "SELECT * FROM dnd_monsters WHERE id = $1;",
            //               $_GET["databaseID"]
            //             );
            //             $attributes = $this->database->query(
            //               "SELECT * FROM dnd_attributes WHERE monsterID = $1;",
            //               $_GET["databaseID"]
            //             );
            //
            //             print_r($monster);
            //             print_r($attributes);
            //             exit();

            require "/opt/src/templates/monster-editor/monster-editor.php";
            $this->resetMessages();
            exit();

          case true:
            if ($this->isAuthenticated()) {
              // MARK: TODO
              // Turn disabled inputs into readonly inputs
              // Include values like ability modifier as inputs

              // LOAD REGULAR PAGE
              require "/opt/src/templates/monster-editor/monster-editor.php";
              $this->resetMessages();
              exit();
            }

            // LOAD PAGE WITHOUT SAVE OPTION
            $this->addMessage("warning", "Your progress may not be saved. To save your progress, please log in.");
            require "/opt/src/templates/monster-editor/monster-editor.php";

            // MARK: TODO
            // Handle this better so it meets validation guidelines
            echo "
            <script>
              document.getElementById(\"saveButton\").remove();
            </script>
            ";
            $this->resetMessages();
            exit();
        }

      case "POST":
        if (!$this->isAuthenticated())
          $this->errorResponse(401, "You must be logged in to edit this resource.");

        $output = $this->formValidation();
        if ($output !== true)
          $this->errorResponse(400, "Your request to edit this resource was invalid or malformed. $output");

        switch (empty($_GET["databaseID"])) {
          case false:
            if (!$this->checkPermissions($_GET["databaseID"], $_SESSION["userID"]))
              $this->errorResponse(403, "You do not have permission to edit this resource");

            $this->updateMonster($_GET["databaseID"]);
            // header("Location: monster-editor.php?databaseID={$_GET["databaseID"]}");
            exit();

          case true:
            $monsterID = $this->addMonster();
            // header("Location: monster-editor.php?databaseID=$monsterID");
            exit();
        }

      default:
        $this->errorResponse(405, "This request method is not supported.");
    }
  }

  // Checks whether the given monster is owned by the given user.
  protected function checkPermissions(int $monsterID, int $userID): bool
  {
    $result = $this->database->query(
      "SELECT * FROM dnd_monsters WHERE (id, userID) = ($1, $2);",
      $monsterID,
      $userID,
    );

    return !empty($result);
  }

  /**
   * Checks whether the form inputs are valid.
   * Returns true on success and an error message on failure.
   */
  protected function formValidation(): bool | string
  {
    $requiredFields = [
      "regex" => [
        "name" => self::REGEX,
      ],

      "options" => [
        "size" => [
          "Tiny",
          "Small",
          "Medium",
          "Large",
          "Huge",
          "Gargantuan"
        ],
        "type" => [
          "Aberration",
          "Beast",
          "Celestial",
          "Construct",
          "Dragon",
          "Elemental",
          "Fey",
          "Fiend",
          "Giant",
          "Humanoid",
          "Monstrosity",
          "Ooze",
          "Plant",
          "Undead",
          "Other",
        ],
        "alignment" => [
          "Lawful Good",
          "Neutral Good",
          "Chaotic Good",
          "Lawful Neutral",
          "True Neutral",
          "Chaotic Neutral",
          "Lawful Evil",
          "Neutral Evil",
          "Chaotic Evil",
        ],
        "armor" => [
          "None",
          "Padded",
          "Leather",
          "Studded Leather",
          "Hide",
          "Chain Shirt",
          "Scale Mail",
          "Spiked Armor",
          "Breastplate",
          "Halfplate",
          "Ring Mail",
          "Chain Mail",
          "Splint",
          "Plate",
          "Natural Armor",
          "Other",
        ],
      ],

      "range" => [
        "speedRange" => [0, 1000, 5],
        "strengthScore" => [1, 30, 1],
        "dexterityScore" => [1, 30, 1],
        "constitutionScore" => [1, 30, 1],
        "intelligenceScore" => [1, 30, 1],
        "wisdomScore" => [1, 30, 1],
        "charismaScore" => [1, 30, 1],
      ],

      "boolean" => [],
    ];

    $optionalFields = [
      "regex" => [],

      "options" => [
        "challengeRadio" => ["estimated", "custom"],
      ],

      "range" => [
        "hitDice" => [0, 1000, 1],
        "health" => [0, 1000, 1],
        "armorClass" => [0, 30, 1],
        "telepathy" => [0, 1000, 5],
        "challengeRatingSelect" => [0, 30, 1, ["1/8", "1/4", "1/2"]],
        "estimatedChallengeRating" => [0, 30, 1, ["1/8", "1/4", "1/2"]],
      ],

      "boolean" => [
        "shield" => null,
        "strengthSavingThrow" => null,
        "dexteritySavingThrow" => null,
        "constitutionSavingThrow" => null,
        "intelligenceSavingThrow" => null,
        "wisdomSavingThrow" => null,
        "charismaSavingThrow" => null,
        "blind" => null,
      ],
    ];

    $attributeFields = [
      "regex" => [
        "speedName" => self::REGEX,
        "skillProficiencyName" => self::REGEX,
        "skillExpertiseName" => self::REGEX,
        "damageVulnerabilityName" => self::REGEX,
        "damageResistanceName" => self::REGEX,
        "damageImmunityName" => self::REGEX,
        "conditionImmunityName" => self::REGEX,
        "senseName" => self::REGEX,
        "languageName" => self::REGEX,
        "abilityName" => self::REGEX,
        "abilityDescription" => self::REGEX,
        "actionName" => self::REGEX,
        "actionDescription" => self::REGEX,
        "bonusActionName" => self::REGEX,
        "bonusActionDescription" => self::REGEX,
        "reactionName" => self::REGEX,
        "reactionDescription" => self::REGEX,
        "legendaryAbilityName" => self::REGEX,
        "legendaryAbilityDescription" => self::REGEX,
      ],

      "options" => [],

      "range" => [
        "speedRange" => [0, 1000, 5],
        "senseRange" => [0, 1000, 5],
        "abilityBenefit" => [-1, 2, 1],
        "actionBenefit" => [-1, 2, 1],
        "bonusActionBenefit" => [-1, 2, 1],
        "reactionBenefit" => [-1, 2, 1],
        "legendaryAbilityBenefit" => [-1, 2, 1],
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
      foreach ($requiredFields as $type => $field) {
        foreach ($field as $fieldName => $conditions) {
          if (!isset($_POST[$fieldName]) || $_POST[$fieldName] === "")
            return "'$fieldName' was required but not provided.";

          if ($type === 'boolean')
            $_POST[$fieldName] = 'true';

          $output = $this->validate($type, $conditions, $_POST[$fieldName]);
          if ($output !== true)
            return "Value for '$fieldName' is invalid: $output.";
        }
      }

      // OPTIONAL FIELDS
      foreach ($optionalFields as $type => $field) {
        foreach ($field as $fieldName => $conditions) {
          if ($type === 'boolean')
            $_POST[$fieldName] = isset($_POST[$fieldName]) ? 'true' : 'false';

          if (!isset($_POST[$fieldName]) || $_POST[$fieldName] === "") {
            $_POST[$fieldName] = null;
            continue;
          }

          $output = $this->validate($type, $conditions, $_POST[$fieldName]);
          if ($output !== true)
            return "Value for '$fieldName' is invalid: $output.";
        }
      }

      // ATTRIBUTE FIELDS
      foreach ($attributeFields as $type => $field) {
        foreach ($field as $fieldRoot => $conditions) {
          foreach ($_POST as $fieldName => $value) {
            if (!strpos($fieldName, $fieldRoot))
              continue;

            if ($type === 'boolean')
              $_POST[$fieldName] = isset($_POST[$fieldName]) ? 'true' : 'false';

            if (!isset($_POST[$fieldName]) || $_POST[$fieldName] === "")
              return "Value for '$fieldName' was not provided.";

            $output = $this->validate($type, $conditions, $value);
            if ($output !== true)
              return "Value for '$fieldName' is invalid: $output.";
          }
        }
      }

      // CHECK FOR DEPENDENCIES ON OTHER INPUTS
      if ($_POST["armor"] === "Natural Armor" || $_POST["armor"] === "Other") {
        if (empty($_POST["armorClass"]))
          return "Value for 'armorClass' must be set when 'Natural Armor' or 'Other' is selected.";
      }

      if (empty($_POST["health"]) && empty($_POST["hitDice"]))
        return "At least one of the following must be set: 'hitDice', 'health'.";

    // CATCH ERRORS
    } catch (ValueError) {
      return "Value Error: One of the request fields was malformed or missing.";
    }

    return true;
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

  // Creates records in the database from $_POST and returns the new monster's ID.
  private function addMonster(): int
  {
    $monsterID = $this->database->query(
      "INSERT INTO dnd_monsters (
        userID,
        name,
        size,
        type,
        alignment,
        armor,
        shield,
        armorClass,
        hitDice,
        health,
        speedRange,
        strength,
        dexterity,
        constitution,
        intelligence,
        wisdom,
        charmisma,
        strengthSavingThrow,
        dexteritySavingThrow,
        constitutionSavingThrow,
        intelligenceSavingThrow,
        wisdomSavingThrow,
        charmismaSavingThrow,
        blind,
        telepathy,
        challenge
      ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8, $9, $10,
        $11, $12, $13, $14, $15, $16, $17, $18, $19, $20,
        $21, $22, $23, $24, $25, $26
      ) RETURNING id;",
      $_SESSION["userID"],
      $_POST["name"],
      $_POST["size"],
      $_POST["type"],
      $_POST["alignment"],
      $_POST["armor"],
      $_POST["shield"],
      $_POST["armorClass"],
      $_POST["hitDice"],
      $_POST["health"],
      $_POST["speedRange"],
      $_POST["strengthScore"],
      $_POST["dexterityScore"],
      $_POST["constitutionScore"],
      $_POST["intelligenceScore"],
      $_POST["wisdomScore"],
      $_POST["charismaScore"],
      $_POST["strengthSavingThrow"],
      $_POST["dexteritySavingThrow"],
      $_POST["constitutionSavingThrow"],
      $_POST["intelligenceSavingThrow"],
      $_POST["wisdomSavingThrow"],
      $_POST["charismaSavingThrow"],
      $_POST["blind"],
      $_POST["telepathy"],
      $_POST["challengeRadio"] === "custom" ? $_POST["challengeRatingSelect"] : $_POST["estimatedChallengeRating"]
    )[0]["id"];

    /**
     * Each attribute value is passed separately, requiring some re-construction.
     * Each attribute has a name, and may include a range, description, and/or benefit value.
     * In addition, each attribute ends with a unique ID value.
     *
     * This implementation is VERY INEFFICIENT.
     */
    $attributes = [];
    for ($i = 1; $i < $_POST["IDCounter"]; $i++) {
      foreach ($_POST as $fieldName => $value) {
        if (str_ends_with($fieldName, $i)) {
          $fieldName = str_replace($i, "", $fieldName);

          if (!key_exists($i, $attributes)) {
            $attributes[$i] = [
              "Type" => str_replace(["Name", "Range", "Description", "Benefit"], "", $fieldName),
              "Name" => null,
              "Range" => null,
              "Description" => null,
              "Benefit" => null,
            ];
          }

          $attributes[$i][str_replace($attributes[$i]["Type"], "", $fieldName)] = $value;
        }
      }
    }

    foreach ($attributes as $_ => $attribute) {
      $this->database->query(
        "INSERT INTO dnd_attributes (
            monsterID,
            type,
            name,
            range,
            description,
            benefit
          ) VALUES (
            $1, $2, $3, $4, $5, $6
          );",
        $monsterID,
        $attribute["Type"],
        $attribute["Name"],
        $attribute["Range"],
        $attribute["Description"],
        $attribute["Benefit"]
      );
    }

    return $monsterID;
  }

  // Updates records in the database from $_POST.
  private function updateMonster(int $monsterID): void
  {
    $this->database->query(
      "UPDATE dnd_monsters * SET (
        name,
        size,
        type,
        alignment,
        armor,
        shield,
        armorClass,
        hitDice,
        health,
        speedRange,
        strength,
        dexterity,
        constitution,
        intelligence,
        wisdom,
        charmisma,
        strengthSavingThrow,
        dexteritySavingThrow,
        constitutionSavingThrow,
        intelligenceSavingThrow,
        wisdomSavingThrow,
        charmismaSavingThrow,
        blind,
        telepathy,
        challenge
      ) = (
        $1, $2, $3, $4, $5, $6, $7, $8, $9, $10,
        $11, $12, $13, $14, $15, $16, $17, $18, $19, $20,
        $21, $22, $23, $24, $25
      ) WHERE id = $26;",
      $_POST["name"],
      $_POST["size"],
      $_POST["type"],
      $_POST["alignment"],
      $_POST["armor"],
      $_POST["shield"],
      $_POST["armorClass"],
      $_POST["hitDice"],
      $_POST["health"],
      $_POST["speedRange"],
      $_POST["strengthScore"],
      $_POST["dexterityScore"],
      $_POST["constitutionScore"],
      $_POST["intelligenceScore"],
      $_POST["wisdomScore"],
      $_POST["charismaScore"],
      $_POST["strengthSavingThrow"],
      $_POST["dexteritySavingThrow"],
      $_POST["constitutionSavingThrow"],
      $_POST["intelligenceSavingThrow"],
      $_POST["wisdomSavingThrow"],
      $_POST["charismaSavingThrow"],
      $_POST["blind"],
      $_POST["telepathy"],
      $_POST["challengeRadio"] === "custom" ? $_POST["challengeRatingSelect"] : $_POST["estimatedChallengeRating"],
      $monsterID
    );

    // Probably inefficient.
    $this->database->query(
      "DELETE FROM dnd_attributes WHERE monsterID = $1;", $monsterID
    );

    /**
     * Each attribute value is passed separately, requiring some re-construction.
     * Each attribute has a name, and may include a range, description, and/or benefit value.
     * In addition, each attribute ends with a unique ID value.
     *
     * This implementation is VERY INEFFICIENT.
     */
    $attributes = [];
    for ($i = 1; $i < $_POST["IDCounter"]; $i++) {
      foreach ($_POST as $fieldName => $value) {
        if (str_ends_with($fieldName, $i)) {
          $fieldName = str_replace($i, "", $fieldName);

          if (!key_exists($i, $attributes)) {
            $attributes[$i] = [
              "Type" => str_replace(["Name", "Range", "Description", "Benefit"], "", $fieldName),
              "Name" => null,
              "Range" => null,
              "Description" => null,
              "Benefit" => null,
            ];
          }

          $attributes[$i][str_replace($attributes[$i]["Type"], "", $fieldName)] = $value;
        }
      }
    }

    foreach ($attributes as $_ => $attribute) {
      $this->database->query(
        "INSERT INTO dnd_attributes (
            monsterID,
            type,
            name,
            range,
            description,
            benefit
          ) VALUES (
            $1, $2, $3, $4, $5, $6
          );",
        $monsterID,
        $attribute["Type"],
        $attribute["Name"],
        $attribute["Range"],
        $attribute["Description"],
        $attribute["Benefit"]
      );
    }
  }
}
