<?php
if (isset($SCRIPTS)) {
  foreach ($SCRIPTS as $script) {
    echo "<script src=\"$script\"></script>\n";
  }
}
?>