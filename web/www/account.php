<!DOCTYPE html>
<html lang="en">

<?php include '/opt/src/templates/base.php';?>

<body>
  <?php include '/opt/src/templates/navbar.php';?>
  <header class="container p-4 text-center">
    <h1>
      Account
    </h1>
  </header>

  <section class="container text-center">
    <h2>My Monsters</h2>

    <div class="d-flex flex-column mx-auto">
      <?php include '/opt/src/templates/account/monster.php'; ?>
      <?php include '/opt/src/templates/account/monster.php'; ?>
      <?php include '/opt/src/templates/account/monster.php'; ?>
    </div>

    <a role="button" class="btn btn-success mt-1" href="/monster-editor.php">New</a>
  </section>

  <?php include '/opt/src/templates/footer.php';?>
  <?php include '/opt/src/templates/base-javascript.php';?>
</body>
</html>