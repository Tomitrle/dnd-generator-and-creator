<div class="row mb-1">
  <div class="mb-1 d-flex align-items-center justify-content-start   col-8   col-sm-2 justify-content-sm-center">
    <label for="<?php echo $CATEGORY; ?>Score" class="form-label mb-0"><?php echo ucfirst($CATEGORY); ?></label>
  </div>

  <div class="mb-1 text-center   d-block col-4   d-sm-none">
    Modifier
  </div>

  <div class="   col-8   col-sm-5">
    <input id="<?php echo $CATEGORY; ?>Score" name="<?php echo $CATEGORY; ?>Score" class="form-control text-center" type="number" min="1" max="30" value="10" aria-required="true" required>
  </div>

  <div id="<?php echo $CATEGORY; ?>Modifier" class="d-flex align-items-center justify-content-center   col-4   col-sm-1">
    0
  </div>

  <div class="d-flex   mb-3   col-sm-4 mb-sm-0 align-items-sm-center justify-content-sm-center">
    <div class="form-check mt-1">
      <input id="<?php echo $CATEGORY; ?>SavingThrow" name="<?php echo $CATEGORY; ?>SavingThrow" class="form-check-input" type="checkbox" aria-label="Saving Throw">
      <label class="form-check-label" for="<?php echo $CATEGORY; ?>SavingThrow">Saving Throw</label>
    </div>
  </div>
</div>