<?php
// MARK: TODO
// Remove this file
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
$_SESSION["userID"] = 1;

header("Location: index.php");
exit();
