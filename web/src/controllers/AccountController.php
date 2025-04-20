<?php
class AccountController extends BaseController
{
  public function run(): void
  {
    if (!$this->isAuthenticated()) {
      header("Location: /sem9bd/login.php");
      exit();
    }

    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        $APIController = new MonsterAPIController();
        $MONSTERS = $APIController->getMonsters($_SESSION["user_id"]);
        require "{$GLOBALS['src']}/templates/account/account.php";
        exit();

      default:
        $this->errorResponse(405, "This request method is not supported.");
    }
  }
}
