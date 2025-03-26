<?php

/**
 * Sources:
 * https://stackoverflow.com/questions/4064444/returning-json-from-a-php-script
 */

class MonsterAPIController extends BaseController
{
  // MARK: RUN
  public function run(array | null $VARIABLES = null): void
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        switch (empty($_GET["monsterID"])) {
          case false:
            // CHECK FOR AUTHENTICATION AND PERMISSION
            if (!$this->isAuthenticated())
              $this->errorResponse(401, "You must be logged in to access this resource.");

            if (!$this->checkPermissions($_GET["monsterID"], $_SESSION["userID"]))
              $this->errorResponse(403, "You do not have permission to access this resource.");

            if (!isset($_GET["command"]))
              $_GET["command"] = "";

            // ACT BASED ON THE GIVEN COMMAND. DEFAULT TO VIEW -> JSON
            switch ($_GET["command"]) {
              case "create":
                $this->createMonster($VARIABLES);
                return;

              case "update":
                $this->updateMonster($_GET["monsterID"], $VARIABLES);
                return;

              case "delete":
                $this->deleteMonster($_GET["monsterID"]);
                return;

              // VIEW THE REQUESTED MONSTER
              case "view":
              default:
                if (!isset($_GET["format"]))
                  $_GET["format"] = "";

                switch ($_GET["format"]) {
                  case "json":
                  default:
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($this->getMonsterAsArray($_GET["monsterID"]));
                    exit();
                }
            }

          case true:
            $this->errorResponse(400, "A 'monsterID' is required.");
        }

      default:
        $this->errorResponse(405, "This request method is not supported.");
    }
  }

  // MARK: PERMISSIONS
  // Checks whether the given monster is owned by the given user.
  public function checkPermissions(int $monsterID, int $userID): bool
  {
    $result = $this->database->query(
      "SELECT * FROM dnd_monsters WHERE (id, userID) = ($1, $2);",
      $monsterID,
      $userID,
    );

    return !empty($result);
  }

  // MARK: CREATE
  public function createMonster(array $VARIABLES): int
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
      $VARIABLES["name"],
      $VARIABLES["size"],
      $VARIABLES["type"],
      $VARIABLES["alignment"],
      $VARIABLES["armor"],
      $VARIABLES["shield"],
      $VARIABLES["armorClass"],
      $VARIABLES["hitDice"],
      $VARIABLES["health"],
      $VARIABLES["speedRange"],
      $VARIABLES["strengthScore"],
      $VARIABLES["dexterityScore"],
      $VARIABLES["constitutionScore"],
      $VARIABLES["intelligenceScore"],
      $VARIABLES["wisdomScore"],
      $VARIABLES["charismaScore"],
      $VARIABLES["strengthSavingThrow"],
      $VARIABLES["dexteritySavingThrow"],
      $VARIABLES["constitutionSavingThrow"],
      $VARIABLES["intelligenceSavingThrow"],
      $VARIABLES["wisdomSavingThrow"],
      $VARIABLES["charismaSavingThrow"],
      $VARIABLES["blind"],
      $VARIABLES["telepathy"],
      $VARIABLES["challengeRadio"] === "custom" ? $VARIABLES["challengeRatingSelect"] : $VARIABLES["estimatedChallengeRating"]
    )[0]["id"];

    /**
     * Each attribute value is passed separately, requiring some re-construction.
     * Each attribute has a name, and may include a range, description, and/or benefit value.
     * In addition, each attribute ends with a unique ID value.
     *
     * This implementation is VERY INEFFICIENT.
     */
    $attributes = [];
    for ($i = 1; $i < $VARIABLES["IDCounter"]; $i++) {
      foreach ($VARIABLES as $fieldName => $value) {
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

  // MARK: UPDATE
  public function updateMonster(int $monsterID, array $VARIABLES): void
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
      $VARIABLES["name"],
      $VARIABLES["size"],
      $VARIABLES["type"],
      $VARIABLES["alignment"],
      $VARIABLES["armor"],
      $VARIABLES["shield"],
      $VARIABLES["armorClass"],
      $VARIABLES["hitDice"],
      $VARIABLES["health"],
      $VARIABLES["speedRange"],
      $VARIABLES["strengthScore"],
      $VARIABLES["dexterityScore"],
      $VARIABLES["constitutionScore"],
      $VARIABLES["intelligenceScore"],
      $VARIABLES["wisdomScore"],
      $VARIABLES["charismaScore"],
      $VARIABLES["strengthSavingThrow"],
      $VARIABLES["dexteritySavingThrow"],
      $VARIABLES["constitutionSavingThrow"],
      $VARIABLES["intelligenceSavingThrow"],
      $VARIABLES["wisdomSavingThrow"],
      $VARIABLES["charismaSavingThrow"],
      $VARIABLES["blind"],
      $VARIABLES["telepathy"],
      $VARIABLES["challengeRadio"] === "custom" ? $VARIABLES["challengeRatingSelect"] : $VARIABLES["estimatedChallengeRating"],
      $monsterID
    );

    // Probably inefficient.
    $this->database->query(
      "DELETE FROM dnd_attributes WHERE monsterID = $1;",
      $monsterID
    );

    /**
     * Each attribute value is passed separately, requiring some re-construction.
     * Each attribute has a name, and may include a range, description, and/or benefit value.
     * In addition, each attribute ends with a unique ID value.
     *
     * This implementation is VERY INEFFICIENT.
     */
    $attributes = [];
    for ($i = 1; $i < $VARIABLES["IDCounter"]; $i++) {
      foreach ($VARIABLES as $fieldName => $value) {
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

  // MARK: DELETE
  public function deleteMonster(int $monsterID): void
  {
    $this->database->query(
      "DELETE FROM dnd_monsters WHERE id = $1;", $monsterID
    );
  }

  // MARK: QUERY
  public function getMonsterAsArray(int $monsterID): array
  {
    $monster = $this->database->query(
      "SELECT * FROM dnd_monsters WHERE id = $1;",
      $monsterID
    )[0];

    foreach ($monster as $key => $value) {
      if ($key === "id" || $key === "userid") unset($monster[$key]);
    }

    $attributes = $this->database->query(
      "SELECT * FROM dnd_attributes WHERE monsterID = $1;",
      $monsterID
    );

    foreach ($attributes as $attributeKey => $attribute) {
      foreach ($attribute as $valueKey => $value) {
        if ($value === null || $valueKey === "id" || $valueKey === "monsterid") unset($attributes[$attributeKey][$valueKey]);
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

  public function getMonsterIDs(int $userID): array
  {
    $ids = $this->database->query(
      "SELECT id FROM dnd_monsters WHERE userID = $1;",
      $userID
    );
    foreach ($ids as $index => $array) {
      $ids[$index] = $array["id"];
    }

  return $ids;
  }
}
