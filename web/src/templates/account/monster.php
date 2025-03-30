<div class="row my-2">
  <div class="col-sm-6 text-sm-end" style="font-size:x-large;">
    <?php echo $MONSTER[1]; ?>
  </div>

  <div class="col-sm-6 text-sm-start">
    <a class="btn btn-secondary" href="monster-api.php?command=view&monster_id=<?php echo $MONSTER[0]; ?>" target="_blank" aria-label="View <?php echo $MONSTER[1]; ?>">View</a>
    <a class="btn btn-warning" href="monster-editor.php?monster_id=<?php echo $MONSTER[0]; ?>" aria-label="Edit <?php echo $MONSTER[1]; ?>">Edit</a>
    <a class="btn btn-danger" href="monster-api.php?command=delete&monster_id=<?php echo $MONSTER[0]; ?>" aria-label="Delete <?php echo $MONSTER[1]; ?>">Delete</a>
  </div>
</div>