<div class="container">
  <?php
    if (!isset($ALERTS)) $ALERTS = [];

    foreach (["danger", "warning", "info", "success"] as $type) {
      if (!isset($ALERTS[$type])) continue;

      foreach ($ALERTS[$type] as $message) {
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
