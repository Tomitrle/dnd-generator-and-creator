<div class="row mb-1" onclick="deleteSelf(event, this)">
  <!-- REQUIRES js/delete.js -->
  <input type="hidden" class="form-control" id="<?php echo $NAME . $UNIQUE_ID; ?>" name="<?php echo $NAME . $UNIQUE_ID; ?>" value="">
  <div class="col-11 d-flex align-items-center text-wrap text-break">
    [<?php echo $NAME ?> Name...]
  </div>
  <div class="col-1 gx-0 d-flex align-items-center">
    <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
  </div>
</div>
<?php $UNIQUE_ID += 1; ?>