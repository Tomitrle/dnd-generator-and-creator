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
        switch (empty($_GET["monster_id"])) {
          case false:
            // CHECK FOR AUTHENTICATION AND PERMISSION
            if (!$this->isAuthenticated())
              $this->errorResponse(401, "You must be logged in to access this resource.");

            if (!$this->checkPermissions($_GET["monster_id"], $_SESSION["user_id"]))
              $this->errorResponse(403, "You do not have permission to access this resource.");

            if (!isset($_GET["command"]))
              $_GET["command"] = "";

            // ACT BASED ON THE GIVEN COMMAND. DEFAULT TO VIEW -> JSON
            switch ($_GET["command"]) {
              case "create":
                $this->createMonster($VARIABLES);
                return;

              case "update":
                $this->updateMonster($_GET["monster_id"], $VARIABLES);
                return;

              case "delete":
                $this->deleteMonster($_GET["monster_id"]);
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
                    echo json_encode($this->getMonsterAsArray($_GET["monster_id"]));
                    exit();
                }
            }

          case true:
            $this->errorResponse(400, "A 'monster_id' is required.");
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
      "SELECT * FROM dnd_monsters WHERE (id, user_id) = ($1, $2);",
      $monsterID,
      $userID,
    );

    return !empty($result);
  }

  // MARK: CREATE
  public function createMonster(array $VARIABLES): int
  {
    print_r($VARIABLES);
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
        charmisma_score,

        strength_modifier,
        dexterity_modifier,
        constitution_modifier,
        intelligence_modifier,
        wisdom_modifier,
        charmisma_modifier,

        strength_saving_throw,
        dexterity_saving_throw,
        constitution_saving_throw,
        intelligence_saving_throw,
        wisdom_saving_throw,
        charmisma_saving_throw,

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
        charmisma_score,

        strength_modifier,
        dexterity_modifier,
        constitution_modifier,
        intelligence_modifier,
        wisdom_modifier,
        charmisma_modifier,

        strength_saving_throw,
        dexterity_saving_throw,
        constitution_saving_throw,
        intelligence_saving_throw,
        wisdom_saving_throw,
        charmisma_saving_throw,

        blind,
        telepathy,
        challenge
      ) = (
        $1, $2, $3, $4, $5, $6, $7, $8, $9, $10,
        $11, $12, $13, $14, $15, $16, $17, $18, $19, $20,
        $21, $22, $23, $24, $25, $26, $27, $28, $29, $30,
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
      "SELECT * FROM dnd_attributes WHERE monster_id = $1;",
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
      "SELECT id FROM dnd_monsters WHERE user_id = $1;",
      $userID
    );
    foreach ($ids as $index => $array) {
      $ids[$index] = $array["id"];
    }

  return $ids;
  }
}
