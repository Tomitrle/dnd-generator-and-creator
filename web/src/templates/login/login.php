<?php
$TITLE = "Login";
$AUTHOR = "Tommy Le";
$DESCRIPTION = "Login to the Dungeons & Dragons Generator and Creator.";
$KEYWORDS = "dungeons and dragons, d&d, dnd, login";

$LESS = ["styles/login.less"];
$SCRIPTS = [];
?>

<!-- Sources used: https://getbootstrap.com/docs/5.3/forms/overview/#overview -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Login</title>
    <meta name="author" content="Tommy Le">
    <meta name="description" content="Login to the Dungeons & Dragons Generator and Creator.">
    <meta name="keywords" content="dungeons and dragons, d&d, dnd, login">

    <meta property="og:title" content="Login">
    <meta property="og:description" content="Login to the Dungeons & Dragons Generator and Creator.">
    <meta property="og:type" content="website">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="styles/main.less" rel="stylesheet/less" type="text/css">
    <link href="styles/login.less" rel="stylesheet/less" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
    <script>
        function createAccount() {
            let loginType = document.getElementById("loginType");
            loginType.innerHTML = "<form action=\"?command=create_account\" method=\"post\" class=\"m-4\"><div class=\"row mb-3\"><label for=\"inputUsername\" class=\"form-label\">Username</label><input type=\"text\" name=\"username\" class=\"form-control\" id=\"inputUsername\"></div><div class=\"row mb-3\"><label for=\"inputPassword\" class=\"form-label\">Password</label><input type=\"password\" name=\"password\" class=\"form-control\" id=\"inputPassword\"></div><div class=\"d-flex justify-content-center mt-4\"><button type=\"submit\" class=\"btn btn-success ms-2\" style=\"min-width:100px; font-size:x-large;\">Create Account</button></div></form>";
        }
        function basicLogin() {
            let loginType = document.getElementById("loginType");
            loginType.innerHTML = "<form action=\"?command=login\" method=\"post\" class=\"m-4\"><div class=\"row mb-3\"><label for=\"inputUsername\" class=\"form-label\">Username</label><input type=\"text\" name=\"username\" class=\"form-control\" id=\"inputUsername\"></div><div class=\"row mb-3\"><label for=\"inputPassword\" class=\"form-label\">Password</label><input type=\"password\" name=\"password\" class=\"form-control\" id=\"inputPassword\"></div><div class=\"d-flex justify-content-center mt-4\"><input type=\"button\" class=\"btn btn-secondary ms-2\" style=\"min-width:100px; font-size:x-large;\" value=\"Create Account\" onclick=\"createAccount();\"/><button type=\"submit\" class=\"btn btn-success ms-2\" style=\"min-width:100px; font-size:x-large;\">Login</button></div></form>";
        }
    </script>
</head>

<body onload="basicLogin()">
    <?php require "{$GLOBALS['src']}/templates/javascript.php"; ?>
    <?php require "{$GLOBALS['src']}/templates/navbar.php"; ?>
    <?php require "{$GLOBALS['src']}/templates/alerts.php"; ?>

    <h1>D&D Encounter Generator and Monster Creator</h1>
    <h3>Login to create and save custom monsters!</h3>
    <div class="row my-3">
        <p class="px-5">Welcome to the D&D Encounter Generator and Monster Creator!<br> This is the login page, however, you do NOT have to login to use the encounter generator unless you want an encounter with a custom monster. The accounts for this website enable users to create and edit custom monsters that will be saved to their account and can then be exported and/or used in the encounters. We hope you enjoy!</p>
    </div>
    <div class="row" id="loginType">
        <form action="?command=login" method="post" class="m-4">
            <div class="row mb-3">
                <label for="inputUsername" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="inputUsername">
            </div>
            <div class="row mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword">
            </div>
            <div class="d-flex justify-content-center mt-4">
                <input type="button" class="btn btn-secondary ms-2" style="min-width:100px; font-size:x-large;" value="Create Account" onclick="createAccount();"/>
                <button type="submit" class="btn btn-success ms-2" style="min-width:100px; font-size:x-large;">Login</button>
            </div>
        </form>
    </div>

    <?php require "{$GLOBALS['src']}/templates/footer.php"; ?>
</body>

</html>