<?php

/**
 * Sources:
 * https://stackoverflow.com/questions/7605480/str-replace-for-multiple-items
 */

class MonsterEditorController extends BaseController
{
  public function run(): void
  {
    $APIController = new MonsterAPIController();

    if (!$this->isAuthenticated()) {
      header("Location: login.php");
      exit();
    }

    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        switch (empty($_GET["monster_id"])) {
          case false:
            // LOAD PRE-POPULATED PAGE
            $MONSTER = $APIController->getMonsterAsArray($_GET["monster_id"]);
            require "{$GLOBALS['src']}/templates/monster-editor/monster-editor.php";
            $this->resetMessages();
            exit();

          case true:
            // LOAD REGULAR PAGE
            require "{$GLOBALS['src']}/templates/monster-editor/monster-editor.php";
            $this->resetMessages();
            exit();
        }

      default:
        $this->errorResponse(405, "This request method is not supported.");
    }
  }
}
