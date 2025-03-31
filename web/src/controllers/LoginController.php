<?php

class LoginController extends BaseController
{
    public function __construct($input) {
        parent::__construct();
        $this->input = $input;
    }

    public function run(): void
    {
        $command = "";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch($command) {
            case "login":
                $this->login();
                break;
            case "create_account":
                $this->create_account();
                break;
            default:
                require "/opt/src/templates/login.php";
                $this->resetMessages();
                break;
        }
    }

    private function login(): void
    {
        if (isset($_POST["username"]) && isset($_POST["password"]) &&
            !empty($_POST["username"]) && !empty($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $results = $this->database->query("select * from dnd_users where username = $1;", $username);
            if (empty($results)) {
                $this->addMessage("warning", "There is no user with that username.");
                require "/opt/src/templates/login.php";
                $this->resetMessages();
            } else if (!password_verify($_POST["password"], $results[0]["password"])) {
                $this->addMessage("warning", "Incorrect username or password.");
                require "/opt/src/templates/login.php";
                $this->resetMessages();
            } else {
                $_SESSION["user_id"] = $results[0]['user_id'];
                require "/opt/src/templates/account.php";
                $this->resetMessages();
            }
        }
    }

    private function create_account(): void
    {
        if (isset($_POST["username"]) && isset($_POST["password"]) &&
            !empty($_POST["username"]) && !empty($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $results = $this->database->query("select * from dnd_users where username = $1;", $username);
            if (!empty($results)) {
                $this->addMessage("warning", "There is already a user with that username.");
                require "/opt/src/templates/login.php";
                $this->resetMessages();
            } else {
                $result = $this->database->query("insert into dnd_users (username, password) values ($1, $2);", $username, password_hash($_POST["password"], PASSWORD_DEFAULT));
                $this->addMessage("success", "Account successfully created.");
                require "/opt/src/templates/login.php";
                $this->resetMessages();
            }
        }
    }
}