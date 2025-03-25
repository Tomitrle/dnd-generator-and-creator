<?php
// MARK: TODO
// Remove this file from production once the schema is set
error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
  require "/opt/src/hw6/controllers/$classname.php";
});

$database = new Database();
$database->dropTables();
$database->createTables();

session_destroy();
session_start();

require "index.php";
?>