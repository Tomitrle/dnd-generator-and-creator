<?php
$TITLE = "Account";
$AUTHOR = "Brennen Muller";
$DESCRIPTION = "Your account and saved custom monsters";

$LESS = [];
$SCRIPTS = ["js/account.js", "https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.0.0/jspdf.umd.min.js"];
?>

<!DOCTYPE html>
<html lang="en">
<?php require '/opt/src/templates/head.php'; ?>

<body>
  <?php require '/opt/src/templates/javascript.php'; ?>
  <?php require '/opt/src/templates/navbar.php'; ?>
  <header class="container p-4 text-center">
    <h1>
      Account
    </h1>
  </header>

  <?php require '/opt/src/templates/alerts.php'; ?>

  <section class="container text-center">
    <h2>My Monsters</h2>

    <div class="d-flex flex-column mx-auto">
      <?php
      foreach ($MONSTERS as $MONSTER) {
        require '/opt/src/templates/account/monster.php';
      }
      ?>
    </div>

    <a class="btn btn-success mt-1" href="monster-editor.php">New</a>
  </section>

  <?php require '/opt/src/templates/footer.php'; ?>
</body>

</html>