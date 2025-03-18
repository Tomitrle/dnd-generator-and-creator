
<div class="col-sm-6 col-lg-4" onclick="deleteSelf(event, this)">
  <div class="row mb-1">
    <label for="<?php echo $NAME; ?>Name<?php echo $UNIQUE_ID; ?>" class="form-label">Name</label>
    <div class="col-10">
      <input type="text" pattern=".*\S+.*" id="<?php echo $NAME; ?>Name<?php echo $UNIQUE_ID; ?>" name="<?php echo $NAME; ?>Name<?php echo $UNIQUE_ID; ?>" class="form-control" aria-required="true" required>
    </div>
    <div class="col-2 gx-0 d-flex align-items-center justify-content-center">
      <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
    </div>
  </div>

  <label for="<?php echo $NAME; ?>Description<?php echo $UNIQUE_ID; ?>" class="form-label">Description</label>
  <textarea class="form-control" id="<?php echo $NAME; ?>Description<?php echo $UNIQUE_ID; ?>" name="<?php echo $NAME; ?>Description<?php echo $UNIQUE_ID; ?>" rows="4" aria-required="true" required></textarea>

  <label for="<?php echo $NAME; ?>Benefit<?php echo $UNIQUE_ID; ?>" class="form-label">Power Level: </label><strong class="ms-1" id="<?php echo $NAME; ?>BenefitLabel<?php echo $UNIQUE_ID; ?>">Neutral</strong>
  <input type="range" min="-1" max="2" value="0" id="<?php echo $NAME; ?>Benefit<?php echo $UNIQUE_ID; ?>" name="<?php echo $NAME; ?>Benefit<?php echo $UNIQUE_ID; ?>" class="form-range" oninput="updateSliderLabel(event)">
</div>
<?php $UNIQUE_ID += 1; ?>