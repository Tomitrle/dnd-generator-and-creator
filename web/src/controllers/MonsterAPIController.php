<?php

/**
 * Sources:
 * https://stackoverflow.com/questions/4064444/returning-json-from-a-php-script
 */

class MonsterAPIController extends BaseController
{
  public function run(): void
  {
    // MARK: TODO
    // Make export depend on save
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        switch (empty($_GET["databaseID"])) {
          case false:
            if (!$this->isAuthenticated())
              $this->errorResponse(401, "You must be logged in to view this resource.");

            if (!$this->checkPermissions($_GET["databaseID"], $_SESSION["userID"]))
              $this->errorResponse(403, "You do not have permission to view this resource.");

            if (!isset($_GET["format"])) $_GET["format"] = "";
            switch ($_GET["format"]) {
              case "json":
              default:
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($this->getMonsterAsArray($_GET["databaseID"]));
                exit();
            }

          case true:
            $this->errorResponse(400, "A 'databaseID' is required for the JSON API.");
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

  protected function getMonsterAsArray(int $monsterID): array
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
}
