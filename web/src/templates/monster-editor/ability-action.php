<!-- Must be contained within a ".row" element. -->
<div class="col-sm-6 col-lg-4" onclick="deleteSelf(event, this)">
  <!-- REQUIRES js/monster-power-slider.js -->
  <!-- REQUIRES js/delete.js -->
  <div class="row mb-1">
    <label for="" class="form-label">Name</label>
    <div class="col-10">
      <input type="text" pattern=".*\S+.*" class="form-control" id="" aria-required="true" required>
    </div>
    <div class="col-2 gx-0 d-flex align-items-center justify-content-center">
      <button type="button" class="btn-close" aria-label="Delete" data-action="delete"></button>
    </div>
  </div>
  
  <label for="" class="form-label">Description</label>
  <textarea class="form-control" id="" rows="4" aria-required="true" required></textarea>

  <label for="" class="form-label">Power Level: </label><strong class="ms-1" id="display">Neutral</strong>
  <input type="range" class="form-range" id="range" min="-1" max="2" value="0">
</div>