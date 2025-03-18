<?php
class MonsterEditorController {
  public function __construct() {}

  public function run() : void {
    // TODO: FIND BETTER WAYS TO HANDLE ALERTS
    $ALERTS = [
      "danger" => [],
      "warning" => [],
      "info" => [],
      "success" => []
    ];

    switch ($_SERVER["REQUEST_METHOD"]) {
      // MARK: GET
      case "GET":
        switch (isset($_GET["databaseID"])) {
          case true:
            if (!$this->isAuthenticated()) {
              $this->errorResponse(401, "You must be logged in to edit this resource.");
              return;
            }

            if (!$this->checkPermissions()) {
              $this->errorResponse(403, "You do not have permission to edit this resource.");
              return;
            }

            // TODO: LOAD PRE-POPULATED PAGE
            include "/opt/src/templates/monster-editor/monster-editor.php";
            return;

          case false:
            if ($this->isAuthenticated()) {
              // LOAD REGULAR PAGE
              include "/opt/src/templates/monster-editor/monster-editor.php";
              return;
            }

            // LOAD PAGE WITHOUT SAVE OPTION
            $ALERTS["warning"][] = "Your progress may not be saved. To save your progress, please log in.";
            include "/opt/src/templates/monster-editor/monster-editor.php";
            echo "
            <script>
              document.getElementById(\"saveButton\").remove();
            </script>
            ";
            return;
        }

      // MARK: POST
      case "POST":
        if (!$this->isAuthenticated()) {
          $this->errorResponse(401, "You must be logged in to edit this resource.");
          return;
        }

        $validatorOutput = $this->formValidation();
        if ($validatorOutput === false) {
          $this->errorResponse(400, "Your request to edit this resource was invalid or malformed. Error message: $validatorOutput");
          return;
        }

        switch (isset($_POST["databaseID"])) {
          case true:
            if (!$this->checkPermissions()) {
              $this->errorResponse(403, "You do not have permission to edit this resource");
              return;
            }

            // TODO: CREATE A NEW DATABASE OBJECT
            // WHAT SHOULD BE RETURNED HERE? SHOULD THERE BE REDIRECTS? SHOULD THE RELOAD TARGET CHANGE?
            // HTTPS 200: OK
            return;

          case false:
            // TODO: UPDATE DATABASE MODEL
            var_dump($_POST);
            return;
        }

      default:
        $this->errorResponse(405, "This request method is not supported.");
        return;
    }
  }

  // TODO
  protected function isAuthenticated() : bool {
    return true;
  }

  // TODO
  protected function checkPermissions(): bool
  {
    return false;
  }

  /**
   * MARK: VALIDATION
   * Checks whether the form inputs are valid.
   * Returns true on success and an error message on failure.
   */
  protected function formValidation() : bool | string {
    $requiredFields = [
      "name" => "/\A[\w\s]+\z/",
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
      ],
      "speedRange" => [1, 30, 1],
      "strengthScore" => [1, 30, 1],
      "dexterityScore" => [1, 30, 1],
      "constitutionScore" => [1, 30, 1],
      "intelligenceScore" => [1, 30, 1],
      "wisdomScore" => [1, 30, 1],
      "charismaScore" => [1, 30, 1],
    ];

    $optionalFields = [
      "shield" => ["on"],
      "armorClass" => [0, 30, 1],

      "strengthSvaingThrow" => ["on"],
      "dexteritySvaingThrow" => ["on"],
      "constitutionSvaingThrow" => ["on"],
      "intelligenceSvaingThrow" => ["on"],
      "wisdomSvaingThrow" => ["on"],
      "charismaSvaingThrow" => ["on"],

      "blind" => ["on"],
      "telepathy" => [0, 1000, 5],

      "challengeRadio" => ["estimated", "custom"],

      "challengeRatingSelect" => [
        "0",
        "1/8",
        "1/4",
        "1/2",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        "10",
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "17",
        "18",
        "19",
        "20",
        "21",
        "22",
        "23",
        "24",
        "25",
        "26",
        "27",
        "28",
        "29",
        "30",
      ],
      "estimatedChallengeRating" => [
        "0",
        "1/8",
        "1/4",
        "1/2",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        "10",
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "17",
        "18",
        "19",
        "20",
        "21",
        "22",
        "23",
        "24",
        "25",
        "26",
        "27",
        "28",
        "29",
        "30",
      ]

      // UNUSED:
      // "customHP" => ["on"],
      // "legendaryCheckbox" => ["on"],
    ];

    $variableFields = [
        "speed" => "/\A[\w\s]+\z/",
        "speedRange" => [0, 1000, 5],

        "skillProficiency" => "/\A[\w\s]+\z/",
        "skillExpertise" => "/\A[\w\s]+\z/",
        "damageVulnerability" => "/\A[\w\s]+\z/",
        "damageResistance" => "/\A[\w\s]+\z/",
        "damageImmunity" => "/\A[\w\s]+\z/",
        "conditionImmunity" => "/\A[\w\s]+\z/",

        "sense" => "/\A[\w\s]+\z/",
        "senseRange" => [0, 1000, 5],

        "language" => "/\A[\w\s]+\z/",

        "abilityName" => "/\A[\w\s]+\z/",
        "abilityDescription" => "/\A[\w\s]+\z/",
        "abilityBenefit" => [-1, 2, 1],

        "actionName" => "/\A[\w\s]+\z/",
        "actionDescription" => "/\A[\w\s]+\z/",
        "actionBenefit" => [-1, 2, 1],

        "bonusActionName" => "/\A[\w\s]+\z/",
        "bonusActionDescription" => "/\A[\w\s]+\z/",
        "bonusActionBenefit" => [-1, 2, 1],

        "reactionName" => "/\A[\w\s]+\z/",
        "reactionDescription" => "/\A[\w\s]+\z/",
        "reactionBenefit" => [-1, 2, 1],

        "legendaryAbilityName" => "/\A[\w\s]+\z/",
        "legendaryAbilityDescription" => "/\A[\w\s]+\z/",
        "legendaryAbilityBenefit" => [-1, 2, 1],
    ];

    try {
      // REQUIRED FIELDS
      foreach ($requiredFields as $fieldName => $conditions) {
        if (!isset($_POST[$fieldName])) return "'$fieldName' was required but not set.";
        if (!$this->validate($conditions, $_POST[$fieldName])) return "Value for field '$fieldName': '{$_POST[$fieldName]}' is invalid.";
      }

      // OPTIONAL FIELDS
      foreach ($optionalFields as $fieldName => $conditions) {
        if (!isset($_POST[$fieldName])) continue;
        if (!$this->validate($conditions, $_POST[$fieldName])) return "Value for field '$fieldName': '{$_POST[$fieldName]}' is invalid.";
      }

      // OPTIONAL FIELDS THAT MAY APPEAR MANY TIMES
      foreach ($variableFields as $fieldName => $conditions) {
        foreach ($_POST as $field => $value) {
          if (!strpos($field, $fieldName)) continue;
          if (!$this->validate($conditions, $value)) return "Value for field '$fieldName': '$value' is invalid.";
        }
      }

      // OTHER: VALUES HAVE ALREADY BEEN CHECKED
      if ($_POST["armor"] === "Natural Armor" || $_POST["armor"] === "Other") {
        if (!isset($_POST["armorClass"])) return "Value for fields 'armor' or 'armorClass' must be set.";
      }

      if (!isset($_POST["health"]) && !isset($_POST["hitDice"])) return "Value for fields 'hitDice' or 'health' must be set.";

    } catch (ValueError) {
      return false;
    }

    return true;
  }

  // MAY THROW VALUE ERROR
  private function validate($conditions, $value) : bool {
    // MATCH REGULAR EXPRESSION
    if (gettype($conditions) === "string") {
      if (!preg_match($conditions, $value)) return false;
    }

    if (gettype($conditions) === "array") {
      // LIST OF OPTIONS
      if (gettype($conditions[0]) === "string") {
        if (!in_array($value, $conditions, true)) return false;
      }

      // INCLUSIVE RANGE (START, END, STEP)
      else if (gettype($conditions[0] === "integer")) {
        if ($value < $conditions[0] || $value > $conditions[1] || ($value - $conditions[0]) % $conditions[2] > 0)
          return false;
      }
    }

    return true;
  }

  protected function errorResponse(int $code, string $message) : void {
    http_response_code($code);
    echo "
    <!DOCTYPE html>
    <html lang=\"en\">

    <head>
      <meta charset=\"UTF-8\">
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
      <title>Error</title>
      <meta name=\"author\" content=\"Brennen Muller\">
    </head>

    <body>
      <h1>HTTP $code</h1>
      <p>$message</p>
    </body>

    </html>";
  }
}
?>