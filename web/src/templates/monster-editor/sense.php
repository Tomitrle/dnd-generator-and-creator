<div class="row mb-1"onclick="deleteSelf(event, this)">
  <!-- REQUIRES js/delete.js -->
  <div class="col-6 d-flex align-items-center text-wrap text-break">
    [Sense Name...]
  </div>
  <div class="col-5 text-wrap text-break">
    <input type="hidden" class="form-control" id="sense<?php echo $UNIQUE_ID; ?>" name="sense<?php echo $UNIQUE_ID; ?>" value="Sense">
    <input type="number" min="0" step="5" class="form-control" id="senseRange<?php echo $UNIQUE_ID; ?>" name="senseRange<?php echo $UNIQUE_ID; ?>" placeholder="0 ft" aria-required="true" required>
  </div>
  <div class="col-1 gx-0 d-flex align-items-center">
    <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
  </div>
</div>
<?php $UNIQUE_ID += 1; ?>