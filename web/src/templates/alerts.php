<div class="container">
  <?php
  foreach ($_SESSION["messages"] as $type => $messages) {
    foreach ($messages as $message) {
      echo "
        <div class=\"alert alert-$type alert-dismissible\" role=\"alert\">
          <div>$message</div>
          <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
        </div>
      ";
    }
  }
  ?>
</div>