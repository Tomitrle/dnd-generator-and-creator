<!DOCTYPE html>
<html lang="en">

<!-- Source: https://www.w3schools.com/PHP/php_includes.asp -->
<?php include '/opt/src/templates/base.html';?>

<body>
  <?php include '/opt/src/templates/navbar.html';?>
  <header class="container p-4 text-center">
    <h1>
      Account
    </h1>
  </header>

  <section class="container text-center">
    <h2>My Monsters</h2>

    <div class="d-flex flex-column w-50 mx-auto">
      <?php include '/opt/src/templates/account/monster.html'; ?>
      <?php include '/opt/src/templates/account/monster.html'; ?>
      <?php include '/opt/src/templates/account/monster.html'; ?>
    </div>

    <a role="button" class="btn btn-success mt-1" href="/monster-editor.html">New</a>
  </section>

  <?php include '/opt/src/templates/footer.html';?>
  <?php include '/opt/src/templates/base-javascript.html';?>
</body>
</html>