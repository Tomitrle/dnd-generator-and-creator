<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
  require "../src/controllers/$classname.php";
});

$controller = new MonsterEditorController();
$controller->run();
?>