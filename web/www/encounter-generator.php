<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
    include "../src/controllers/$classname.php";
});

$controller = new EncounterGeneratorController($_GET);
$controller->run();
?>