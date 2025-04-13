<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
  require "/opt/src/controllers/$classname.php";
});

$database = new Database();
$database->dropTables();
$database->createTables();

session_start();
session_destroy();
session_start();

exit();
?>