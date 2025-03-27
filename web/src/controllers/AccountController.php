<?php
class AccountController extends BaseController
{
  public function run(): void
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        if (!$this->isAuthenticated()) {
          header("Location: login.php");
          exit();
        }

        $APIController = new MonsterAPIController();
        $MONSTER_IDS = $APIController->getMonsterIDs($_SESSION["user_id"]);
        require "/opt/src/templates/account/account.php";
        exit();

      default:
        $this->errorResponse(405, "This request method is not supported.");
    }
  }
}
