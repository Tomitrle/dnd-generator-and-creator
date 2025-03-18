<div class="my-2 text-center">
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#<?php echo $CATEGORY; ?>Modal" data-category="<?php echo $CATEGORY; ?>" onclick="updateAttributeChoices(this)">Add</button>
</div>
<div id="<?php echo $CATEGORY; ?>Modal" class="modal fade" tabindex="-1" aria-labelledby="<?php echo $CATEGORY; ?>ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 id="<?php echo $CATEGORY; ?>ModalLabel" class="modal-title fs-5">Add <?php echo ucfirst(preg_replace("/(?<![A-Z])[A-Z]/", ' $0', $CATEGORY)); ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id=<?php echo $CATEGORY . "AddContainer"; ?>>
          <?php
          foreach ($OPTIONS as $OPTION) {
            include '/opt/src/templates/monster-editor/attribute-modal-choice.php';
          }
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>