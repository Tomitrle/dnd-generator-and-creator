<div class="row my-2">
  <div class="col-sm-6 text-sm-end" style="font-size:x-large;">
    Custom Monster
  </div>

  <div class="col-sm-6 text-sm-start">
    <a type="button" class="btn btn-secondary" href="/monster-api.php?command=view&monsterID=<?php echo $ID; ?>" target="_blank">View</a>
    <a role="button" class="btn btn-warning" href="/monster-editor.php?monsterID=<?php echo $ID; ?>">Edit</a>
    <a type="button" class="btn btn-danger" href="/monster-api.php?command=delete&monsterID=<?php echo $ID; ?>">Delete</a>
  </div>
</div>