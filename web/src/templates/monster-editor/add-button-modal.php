<div class="my-2 text-center">
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#<?php echo $NAME; ?>Modal" data-name="<?php echo $NAME; ?>" onclick="updateChoices(this)">Add</button>
</div>

<div class="modal fade" id="<?php echo $NAME; ?>Modal" tabindex="-1" aria-labelledby="<?php echo $NAME; ?>ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="<?php echo $NAME; ?>ModalLabel">Add <?php echo ucfirst($NAME); ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>
          <?php
          foreach ($OPTIONS as $OPTION) {
            include '/opt/src/templates/monster-editor/add.php';
          }
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>