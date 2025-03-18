<div class="row" onclick="deleteSelf(event, this)">
  <div class="col-sm-2 mb-1 d-flex justify-content-sm-center align-items-center">
    <label for="speed<?php echo $UNIQUE_ID; ?>" class="form-label" style="margin-bottom:0;">[Speed Name...]</label>
  </div>
  <div class="col-sm-9 col-11 mb-1">
    <input type="hidden" id="speed<?php echo $UNIQUE_ID; ?>" name="speed<?php echo $UNIQUE_ID; ?>">
    <input type="number" min="0" step="5" class="form-control" id="speedRange<?php echo $UNIQUE_ID; ?>" name="speedRange<?php echo $UNIQUE_ID; ?>" placeholder="0 ft" aria-required="true" required>
  </div>
  <div class="col-1 mb-1 d-flex justify-content-start align-items-center gx-0">
    <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
  </div>
</div>
<?php $UNIQUE_ID += 1; ?>