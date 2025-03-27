<?php

/**
 * Sources:
 * https://stackoverflow.com/questions/7605480/str-replace-for-multiple-items
 */

// MARK: TODO
// Make export depend on save

class MonsterEditorController extends BaseController
{
  /**
   * This regular expression is used for input validation.
   * Allows all word characters, whitespace characters, and a select handful of symbols.
   * Hopefully, this should help prevent SQL injection.
   */
  const REGEX = "/\A[\w\s\-\?\,\.\!\&\(\)]+\z/";
  private MonsterAPIController $apiController;

  public function run(): void
  {
    $this->apiController = new MonsterAPIController();

    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        switch (empty($_GET["monster_id"])) {
          case false:
            if (!$this->isAuthenticated())
              $this->errorResponse(401, "You must be logged in to edit this resource.");

            if (!$this->apiController->checkPermissions($_GET["monster_id"], $_SESSION["user_id"]))
              $this->errorResponse(403, "You do not have permission to edit this resource.");

            // MARK: TODO
            // Populate fields with PHP requires
            // Make sure "monster_id" is added as a hidden input

            //             $monster = $this->database->query(
            //               "SELECT * FROM dnd_monsters WHERE id = $1;",
            //               $_GET["monster_id"]
            //             );
            //             $attributes = $this->database->query(
            //               "SELECT * FROM dnd_attributes WHERE monster_id = $1;",
            //               $_GET["monster_id"]
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

        switch (empty($_GET["monster_id"])) {
          case false:
            if (!$this->apiController->checkPermissions($_GET["monster_id"], $_SESSION["user_id"]))
              $this->errorResponse(403, "You do not have permission to edit this resource");

            $this->apiController->updateMonster($_GET["monster_id"], $_POST);
            // header("Location: monster-editor.php?monster_id={$_GET["monster_id"]}");
            exit();

          case true:
            $monsterID = $this->apiController->createMonster($_POST);
            // header("Location: monster-editor.php?monster_id=$monsterID");
            exit();
        }

      default:
        $this->errorResponse(405, "This request method is not supported.");
    }
  }

  /**
   * Checks whether the form inputs are valid.
   * Returns true on success and an error message on failure.
   */
  protected function formValidation(): bool | string
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

        // "speed" => self::REGEX,
        // "skillProficiency" => self::REGEX,
        // "skillExpertise" => self::REGEX,
        // "damageVulnerability" => self::REGEX,
        // "damageResistance" => self::REGEX,
        // "damageImmunity" => self::REGEX,
        // "conditionImmunity" => self::REGEX,
        // "sense" => self::REGEX,
        // "language" => self::REGEX,
        // "ability" => self::REGEX,
        // "action" => self::REGEX,
        // "bonusAction" => self::REGEX,
        // "reaction" => self::REGEX,
        // "legendaryAbility" => self::REGEX,

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
      foreach ($optionalFields as $type => $fields) {
        foreach ($fields as $fieldName => $conditions) {
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
      foreach ($_POST as $category => $categoryFields) {
        if (gettype($categoryFields) !== "array") continue;
        $attributeCount = count(current($categoryFields));

        foreach ($categoryFields as $fieldName => $attributes) {
          if (count($attributes) !== $attributeCount)
            return "A different number of items for each property of attribute '$category' is invalid.";

          foreach ($attributes as $index => $value) {
            foreach ($attributeFields as $type => $fields) {
              if (!in_array($fieldName, $fields)) continue;

              if ($type === 'boolean')
                $_POST[$category][$fieldName][$index] = isset($value) ? 'true' : 'false';

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
}
