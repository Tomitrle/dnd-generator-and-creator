<?php
// TODO: Disable error reporting in production
error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
  include "/opt/src/controllers/$classname.php";
});

$controller = new MonsterEditorController();
$controller->run();
?>