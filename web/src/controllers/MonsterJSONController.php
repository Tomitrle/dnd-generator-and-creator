<?php
class MonsterJSONController extends BaseController
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
              $this->errorResponse(401, "You must be logged in to view this resource.");

            if (!$this->checkPermissions($_GET["databaseID"], $_SESSION["userID"]))
              $this->errorResponse(403, "You do not have permission to view this resource.");

            // MARK: TODO
            exit();

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
}
