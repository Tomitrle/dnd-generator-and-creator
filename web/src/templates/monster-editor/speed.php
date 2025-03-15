<div class="row" onclick="deleteSelf(event, this)">
  <!-- REQUIRES js/delete.js -->
  <div class="col-sm-2 mb-1 d-flex justify-content-sm-center align-items-center">
    <label for="speed<?php echo $UNIQUE_ID; ?>" class="form-label" style="margin-bottom:0;">Speed</label>
  </div>
  <div class="col-sm-9 col-11 mb-1">
    <input type="number" min="0" step="5" class="form-control" id="speed<?php echo $UNIQUE_ID; ?>" placeholder="0 ft" aria-required="true" required>
  </div>
  <div class="col-1 mb-1 d-flex justify-content-start align-items-center gx-0">
    <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
  </div>
</div>
<?php $UNIQUE_ID += 1; ?>