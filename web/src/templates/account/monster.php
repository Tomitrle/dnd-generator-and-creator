<div class="row my-2">
  <div class="col-sm-6 text-sm-end" style="font-size:x-large;">
    <?php echo $MONSTER[1]; ?>
  </div>

  <div class="col-sm-6 text-sm-start">
    <a type="button" class="btn btn-secondary" href="/monster-api.php?command=view&monster_id=<?php echo $MONSTER[0]; ?>" target="_blank">View</a>
    <a role="button" class="btn btn-warning" href="/monster-editor.php?monster_id=<?php echo $MONSTER[0]; ?>">Edit</a>
    <a type="button" class="btn btn-danger" href="/monster-api.php?command=delete&monster_id=<?php echo $MONSTER[0]; ?>">Delete</a>
  </div>
</div>