<div class="row mb-1">
  <div class="mb-1 d-flex align-items-center justify-content-start   col-8   col-sm-2 justify-content-sm-center">
    <label for="<?php echo $ID; ?>" class="form-label mb-0"><?php echo ucfirst($ID);?></label>
  </div>

  <div class="mb-1 text-center   d-block col-4   d-sm-none">
    Modifier
  </div>

  <div class="   col-8   col-sm-5">
    <input type="number" min="1" max="30" value="10" class="form-control text-center" id="<?php echo $ID; ?>Score" aria-required="true" required>
  </div>

  <div class="d-flex align-items-center justify-content-center   col-4   col-sm-1" id="<?php echo $ID; ?>Modifier">
    0
  </div>

  <div class="d-flex   mb-3   col-sm-4 mb-sm-0 align-items-sm-center justify-content-sm-center">
    <div class="form-check mt-1">
      <input class="form-check-input" type="checkbox" id="<?php echo $ID; ?>SavingThrow" aria-label="Saving Throw">
      <label class="form-check-label" for="<?php echo $ID; ?>SavingThrow">Saving Throw</label>
    </div>
  </div>
</div>