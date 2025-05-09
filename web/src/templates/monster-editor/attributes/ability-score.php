<div class="row mb-1">
  <div class="mb-1 d-flex align-items-center justify-content-start   col-8   col-sm-2 justify-content-sm-center">
    <label for="<?php echo $CATEGORY; ?>Score" class="form-label mb-0"><?php echo ucfirst($CATEGORY); ?></label>
  </div>

  <div class="mb-1 text-center   d-block col-4   d-sm-none">
    Modifier
  </div>

  <div class="   col-8   col-sm-5">
    <input id="<?php echo $CATEGORY; ?>Score" name="<?php echo $CATEGORY; ?>_score" class="form-control text-center" type="number" min="1" max="30" value="<?php echo (isset($MONSTER[$CATEGORY . "_score"])) ? $MONSTER[$CATEGORY . "_score"] : "10"; ?>" oninput="updateAbilityModifier(event); updateCR();" aria-required="true" required>
  </div>

  <input id="<?php echo $CATEGORY; ?>Modifier" name="<?php echo $CATEGORY; ?>_modifier" type="hidden" value="<?php echo (isset($MONSTER[$CATEGORY . "_modifier"])) ? $MONSTER[$CATEGORY . "_modifier"] : "0"; ?>">
  <div id="<?php echo $CATEGORY; ?>ModifierLabel" class="d-flex align-items-center justify-content-center   col-4   col-sm-1">
    <?php echo (isset($MONSTER[$CATEGORY . "_modifier"])) ? $MONSTER[$CATEGORY . "_modifier"] : "0"; ?>
  </div>

  <div class="d-flex   mb-3   col-sm-4 mb-sm-0 align-items-sm-center justify-content-sm-center">
    <div class="form-check mt-1">
      <input id="<?php echo $CATEGORY; ?>SavingThrow" name="<?php echo $CATEGORY; ?>_saving_throw" class="form-check-input" type="checkbox" aria-label="Saving Throw" <?php echo (isset($MONSTER[$CATEGORY . "_saving_throw"]) && $MONSTER[$CATEGORY . "_saving_throw"] === "t") ? "checked" : ""; ?>>
      <label class="form-check-label" for="<?php echo $CATEGORY; ?>SavingThrow">Saving Throw</label>
    </div>
  </div>
</div>