<div class="row" onclick="deleteSelf(event, this)">
  <div class="col-sm-2 mb-1 d-flex justify-content-sm-center align-items-center text-center">
    <label class="form-label" for="speedName<?php echo $UNIQUE_ID; ?>" style="margin-bottom:0;">...</label>
  </div>
  <div class="col-sm-9 col-11 mb-1 d-flex justify-content-sm-center align-items-center">
    <input id="speedName<?php echo $UNIQUE_ID; ?>" name="speed[name][]" type="hidden">
    <input id="speedRange<?php echo $UNIQUE_ID; ?>" name="speed[range][]" class="form-control" type="number" min="0" step="5" placeholder="0 ft" aria-required="true" required>
  </div>
  <div class="col-1 mb-1 d-flex justify-content-start align-items-center gx-0">
    <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
  </div>
</div>
<?php $UNIQUE_ID += 1; ?>