<?php
// MARK: TODO
// Remove this file from production once the schema is set
error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
  require "/opt/src/controllers/$classname.php";
});

$database = new Database();
$database->dropTables();
$database->createTables();

$database->query("INSERT INTO dnd_users (username, password) VALUES ($1, $2);", "Brennen", password_hash("admin", PASSWORD_DEFAULT));
$database->query("INSERT INTO dnd_base_monsters (name, type, cr, xp) VALUES ($1, $2, $3, $4);", "Tommy", "humanoid", 1/8, 25);
$database->query("INSERT INTO dnd_base_monsters (name, type, cr, xp) VALUES ($1, $2, $3, $4);", "Tommy at 4AM", "aberration", 1/8, 25);

session_start();
session_destroy();
session_start();

$_SESSION["user_id"] = 1;

exit();
?>