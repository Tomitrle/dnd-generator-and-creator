<div class="row mb-1" onclick="deleteSelf(event, this)">
  <div class="col-6 d-flex align-items-center text-wrap text-break">
    ...
  </div>
  <div class="col-5 text-wrap text-break">
    <input id="sense<?php echo $UNIQUE_ID; ?>" name="sense<?php echo $UNIQUE_ID; ?>" type="hidden">
    <input id="senseRange<?php echo $UNIQUE_ID; ?>" name="senseRange<?php echo $UNIQUE_ID; ?>" class="form-control" type="number" min="0" max="1000" step="5" placeholder="0 ft" aria-required="true" required>
  </div>
  <div class="col-1 gx-0 d-flex align-items-center">
    <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
  </div>
</div>
<?php $UNIQUE_ID += 1; ?>