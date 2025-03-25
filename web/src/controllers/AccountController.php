<?php
class AccountController extends BaseController
{
  public function run(): void
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        if (!$this->isAuthenticated()) {
          // MARK: TODO
          // Replace with new LoginController()->run(); when ready
          require "/opt/src/templates/account/login.php";
          exit();
        }

        // MARK: TODO
        // Query for this user's monster IDs
        require "/opt/src/templates/account/account.php";
        $this->resetMessages();
        exit();

      default:
        $this->errorResponse(405, "This request method is not supported.");
        $this->resetMessages();
        exit();
    }
  }
}
