<div class="row mb-1" onclick="deleteSelf(event, this)">
  <div class="col-6 d-flex align-items-center text-wrap text-break">
    <label class="form-label" for="senseRange<?php echo $UNIQUE_ID; ?>" style="margin-bottom:0;"><?php echo $ATTRIBUTE["name"]; ?></label>
  </div>
  <div class="col-5 text-wrap text-break">
    <input id="senseName<?php echo $UNIQUE_ID; ?>" name="sense[name][]" type="hidden" value="<?php echo $ATTRIBUTE["name"]; ?>">
    <input id="senseRange<?php echo $UNIQUE_ID; ?>" name="sense[range][]" class="form-control" type="number" min="0" max="1000" step="5" placeholder="0 ft" value="<?php echo $ATTRIBUTE["range"]; ?>" aria-required="true" required>
  </div>
  <div class="col-1 gx-0 d-flex align-items-center">
    <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
  </div>
</div>
<?php $UNIQUE_ID += 1; ?>