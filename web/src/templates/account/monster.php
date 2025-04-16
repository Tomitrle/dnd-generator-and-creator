<div class="row my-2" id="monsterContainer<?php echo $MONSTER[0]; ?>">
  <div class="col-sm-6 text-sm-end" style="font-size:x-large;">
    <?php echo $MONSTER[1]; ?>
  </div>

  <div class="col-sm-6 text-sm-start">
    <a class="btn btn-secondary" href="monster-api.php?command=view&monster_id=<?php echo $MONSTER[0]; ?>" target="_blank" aria-label="View <?php echo $MONSTER[1]; ?> JSON">JSON</a>
    <button class="btn btn-info" aria-label="Print Summary for <?php echo $MONSTER[1];?>" onclick="printMonsterSummary(<?php echo $MONSTER[0] ?>);">Summary</button>
    <a class="btn btn-warning" href="monster-editor.php?monster_id=<?php echo $MONSTER[0]; ?>" aria-label="Edit <?php echo $MONSTER[1]; ?>">Edit</a>
    <button class="btn btn-danger" aria-label="Delete <?php echo $MONSTER[1];?>" onclick="deleteMonster(<?php echo $MONSTER[0] ?>);">Delete</button>
  </div>
</div>