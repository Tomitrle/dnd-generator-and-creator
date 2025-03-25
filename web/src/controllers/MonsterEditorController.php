<?php
class MonsterEditorController extends BaseController
{
  const REGEX = "/\A[\w\s\-\?\,\.\!\&\(\)]+\z/";

  public function run(): void
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      // MARK: GET
      case "GET":
        switch (isset($_GET["databaseID"])) {
          case true:
            if (!$this->isAuthenticated())
              $this->errorResponse(401, "You must be logged in to edit this resource.");

            if (!$this->checkPermissions())
              $this->errorResponse(403, "You do not have permission to edit this resource.");

            // MARK: TODO
            // Query and load the database record(s)
            require "/opt/src/templates/monster-editor/monster-editor.php";
            $this->resetMessages();
            exit();

          case false:
            if ($this->isAuthenticated()) {
              // LOAD REGULAR PAGE
              require "/opt/src/templates/monster-editor/monster-editor.php";
              $this->resetMessages();
              exit();
            }

            // LOAD PAGE WITHOUT SAVE OPTION
            $this->addMessage("warning", "Your progress may not be saved. To save your progress, please log in.");
            require "/opt/src/templates/monster-editor/monster-editor.php";
            echo "
            <script>
              document.getElementById(\"saveButton\").remove();
            </script>
            ";
            $this->resetMessages();
            exit();
        }

      // MARK: POST
      case "POST":
        if (!$this->isAuthenticated())
          $this->errorResponse(401, "You must be logged in to edit this resource.");

        $validatorOutput = $this->formValidation();
        if ($validatorOutput !== true)
          $this->errorResponse(400, "Your request to edit this resource was invalid or malformed. Error message: $validatorOutput");

        switch (isset($_POST["databaseID"])) {
          case true:
            if (!$this->checkPermissions())
              $this->errorResponse(403, "You do not have permission to edit this resource");

            // MARK: TODO
            // Create new database record(s)
            return;

          case false:
            // MARK: TODO
            // Update the database record(s)
            var_dump($_POST);
            return;
        }

      default:
        $this->errorResponse(405, "This request method is not supported.");
    }
  }

  // MARK: TODO
  // Query the database and check permissions
  protected function checkPermissions(): bool
  {
    return false;
  }

  /**
   * MARK: VALIDATION
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
        "speedRange" => [1, 30, 1],
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
        "armorClass" => [0, 30, 1],
        "telepathy" => [0, 1000, 5],
        "challengeRatingSelect" => [0, 30, 1, ["1/8", "1/4", "1/2"]],
        "estimatedChallengeRating" => [0, 30, 1, ["1/8", "1/4", "1/2"]],
      ],

      "boolean" => [
        "shield",
        "strengthSvaingThrow",
        "dexteritySvaingThrow",
        "constitutionSvaingThrow",
        "intelligenceSvaingThrow",
        "wisdomSvaingThrow",
        "charismaSvaingThrow",
        "blind",
      ],
    ];

    $variableFields = [
      "regex" => [
        "speed" => self::REGEX,
        "skillProficiency" => self::REGEX,
        "skillExpertise" => self::REGEX,
        "damageVulnerability" => self::REGEX,
        "damageResistance" => self::REGEX,
        "damageImmunity" => self::REGEX,
        "conditionImmunity" => self::REGEX,
        "sense" => self::REGEX,
        "language" => self::REGEX,
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

    try {
      // REQUIRED FIELDS
      foreach ($requiredFields as $type => $field) {
        foreach ($field as $fieldName => $conditions) {
          if (!isset($_POST[$fieldName]) || empty($_POST[$fieldName]))
            return "'$fieldName' was required but not provided.";

          $output = $this->validate($type, $conditions, $_POST[$fieldName]);
          if ($output !== true)
            return "Value for '$fieldName' is invalid: $output.";
        }
      }

      // OPTIONAL FIELDS
      foreach ($optionalFields as $type => $field) {
        foreach ($field as $fieldName => $conditions) {
          if (!isset($_POST[$fieldName]) || empty($_POST[$fieldName]))
            continue;

          $output = $this->validate($type, $conditions, $_POST[$fieldName]);
          if ($output !== true)
            return "Value for '$fieldName' is invalid: $output.";
        }
      }

      // ATTRIBUTE FIELDS
      foreach ($variableFields as $type => $field) {
        foreach ($field as $fieldRoot => $conditions) {
          foreach ($_POST as $fieldName => $value) {
            if (!strpos($fieldName, $fieldRoot))
              continue;

            if (empty($_POST[$fieldName]))
              return "Value for '$fieldName' was not provided.";

            $output = $this->validate($type, $conditions, $value);
            if ($output !== true)
              return "Value for '$fieldName' is invalid: $output.";
          }
        }
      }

      // CHECK FOR DEPENDENCIES
      if ($_POST["armor"] === "Natural Armor" || $_POST["armor"] === "Other") {
        if (!isset($_POST["armorClass"]))
          return "Value for 'armorClass' must be set when 'Natural Armor' or 'Other' is selected.";
      }

      if (!isset($_POST["health"]) && !isset($_POST["hitDice"]))
        return "At least one of the following must be set: 'hitDice', 'health'.";

    } catch (ValueError) {
      return "Value Error: One of the request fields was malformed or missing.";
    }

    return true;
  }

  // MAY THROW VALUE ERROR
  private function validate(string $type, string | array $conditions, mixed $value): bool | string
  {
    switch ($type) {
      case "regex":
        if (!preg_match($conditions, $value)) return "'$value' does not match the regular expression '$conditions'";
        break;

      case "options":
        if (!in_array($value, $conditions, true)) return "'$value' is not in the list of valid options";
        break;

      case "boolean":
        if ($value !== "on") return "'$value' must be 'on'";
        break;

      // INCLUSIVE RANGE (START, END, STEP, [... OTHER ACCEPTED VALUES])
      case "range":
        if (count($conditions) > 3) {
          if (in_array($value, $conditions[3])) return true;
        }

        if ($value < $conditions[0] || $value > $conditions[1] || ($value - $conditions[0]) % $conditions[2] > 0)
          return "'$value' is not in the accepted range";

        break;
    }

    return true;
  }
}
