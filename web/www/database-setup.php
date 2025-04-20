<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
  require "/opt/src/controllers/$classname.php";
});

$database = new Database();
$database->dropTables();
$database->createTables();

$database->query("INSERT INTO dnd_base_monsters (name, type, cr, xp, challenge) VALUES ($1, $2, $3, $4, $5);", "Goblin", "humanoid", 1/4, 50, "1/4");
$database->query("INSERT INTO dnd_base_monsters (name, type, cr, xp, challenge) VALUES ($1, $2, $3, $4, $5);", "Kobold", "humanoid", 1/8, 25, "1/8");
$database->query("INSERT INTO dnd_base_monsters (name, type, cr, xp, challenge) VALUES ($1, $2, $3, $4, $5);", "Ancient Red Dragon", "dragon", 24, 62000, "24");

session_start();
session_destroy();
session_start();

exit();
?>