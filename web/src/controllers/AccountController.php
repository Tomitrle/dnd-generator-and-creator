<?php
class AccountController extends BaseController
{
  public function run(): void
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      // MARK: GET
      case "GET":
        if (!$this->isAuthenticated()) {
          // TODO: Replace with new LoginController()->run(); when ready
          require "/opt/src/templates/account/login.php";
          return;
        }

        // TODO: Query for this user's monster IDs
        $MONSTER_IDS = [1, 210];
        require "/opt/src/templates/account/account.php";
        return;

      default:
        $this->errorResponse(405, "This request method is not supported.");
        return;
    }
  }
}
