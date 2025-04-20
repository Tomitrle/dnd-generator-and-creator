<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
  require "/opt/src/controllers/$classname.php";
});

$database = new Database();
$database->dropTables();
$database->createTables();

$database->query("INSERT INTO dnd_base_monsters (name, type, cr, xp, challenge) VALUES ($1, $2, $3, $4, $5);", "Tommy", "humanoid", 1/8, 25, "1/8");
$database->query("INSERT INTO dnd_base_monsters (name, type, cr, xp, challenge) VALUES ($1, $2, $3, $4, $5);", "Tommy at 4AM", "aberration", 1/4, 25, "1/4");

session_start();
session_destroy();
session_start();

exit();
?>