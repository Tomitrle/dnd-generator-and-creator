<div class="col-sm-6 col-lg-4" onclick="deleteSelf(event, this)">
  <div class="row mb-1">
    <label class="form-label" for="<?php echo $CATEGORY . "Name" . $UNIQUE_ID; ?>">Name</label>
    <div class="col-10">
      <input id="<?php echo $CATEGORY . "Name" . $UNIQUE_ID; ?>" name="<?php echo $CATEGORY . "Name" . $UNIQUE_ID; ?>" class="form-control" type="text" pattern="[\w\s]+" aria-required="true" required>
    </div>
    <div class="col-2 gx-0 d-flex align-items-center justify-content-center">
      <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
    </div>
  </div>

  <label class="form-label" for="<?php echo $CATEGORY . "Description" . $UNIQUE_ID; ?>">Description</label>
  <textarea id="<?php echo $CATEGORY . "Description" . $UNIQUE_ID; ?>" name="<?php echo $CATEGORY . "Description" . $UNIQUE_ID; ?>" class="form-control" rows="4" aria-required="true" required></textarea>

  <label class="form-label" for="<?php echo $CATEGORY . "Benefit" . $UNIQUE_ID; ?>">Power Level:</label><strong id="<?php echo $CATEGORY; ?>BenefitLabel<?php echo $UNIQUE_ID; ?>" class="ms-1">Neutral</strong>
  <input id="<?php echo $CATEGORY . "Benefit" . $UNIQUE_ID; ?>" name="<?php echo $CATEGORY . "Benefit" . $UNIQUE_ID; ?>" class="form-range" type="range" min="-1" max="2" value="0" oninput="updateSliderLabel(event)">
</div>
<?php $UNIQUE_ID += 1; ?>