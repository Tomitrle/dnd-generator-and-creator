<div class="row mb-1" onclick="deleteSelf(event, this)">
  <input id="<?php echo $CATEGORY . "Name" . $UNIQUE_ID; ?>" name="<?php echo $CATEGORY . "Name" . $UNIQUE_ID; ?>" type="hidden">
  <div class="col-11 d-flex align-items-center text-wrap text-break">
    ...
  </div>
  <div class="col-1 gx-0 d-flex align-items-center">
    <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
  </div>
</div>
<?php $UNIQUE_ID += 1; ?>