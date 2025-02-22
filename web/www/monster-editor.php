<!-- TODO: HTML Validation -->
<!-- TODO: Convert to HTML for Sprint 2 -->
<!-- TODO: Connect form options to PHP / PostgreSQL model -->
<!-- TODO: Implement asynchronous save / update requests with AJAX -->
<!-- TODO: Create / delete form elements with custom IDs using PHP / Javascript -->

<!DOCTYPE html>
<html lang="en">

<!-- https://www.w3schools.com/PHP/php_includes.asp -->
<?php include '/opt/src/templates/base.html'; ?>

<body>
  <style>
    h2,
    h3,
    h4,
    h5,
    h6 {
      text-align: center;
    }

    h2 {
      font-size: x-large;
    }

    h3 {
      font-size: large;
    }

    input[readonly] {
      background-color: var(--bs-secondary-bg);
      opacity: 1;
    }

    input[readonly]:focus {
      background-color: var(--bs-secondary-bg);
    }

    textarea {
      resize: none;
    }
  </style>

  <?php include '/opt/src/templates/navbar.html'; ?>

  <!-- TODO: Include a "return to previous page" button -->

  <header class="container text-center">
    <h1>Monster Editor</h1>
  </header>
  
  <hr>

  <!-- Source: https://getbootstrap.com/docs/5.3/forms/overview/ -->
  <!-- Source: https://getbootstrap.com/docs/5.0/forms/validation/ -->
  <form class="container needs-validation" novalidate>
    <h2>General Information</h2>
    <section class="row">
      <div class="col-sm-6 mb-2">
        <label for="name" class="form-label">Name</label>
        <input type="text" pattern=".*\S+.*" class="form-control" id="name" aria-required="true" required>
      </div>

      <!-- Source: https://stackoverflow.com/questions/3518002/how-can-i-set-the-default-value-for-an-html-select-element -->
      <!-- Source: https://stackoverflow.com/questions/13766015/is-it-possible-to-configure-a-required-field-to-ignore-white-space -->
      <div class="col-sm-6 mb-2">
        <label for="size" class="form-label">Size</label>
        <select id="size" class="form-select" aria-required="true" required>
          <option selected disabled hidden value="">Select an option...</option>
          <option>Tiny</option>
          <option>Small</option>
          <option>Medium</option>
          <option>Large</option>
          <option>Huge</option>
          <option>Gargantuan</option>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="type" class="form-label">Type</label>
        <select id="type" class="form-select" aria-required="true" required>
          <option selected disabled hidden value="">Select an option...</option>
          <option>Humanoid</option>
          <option>Other</option>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="alignment" class="form-label">Alignment</label>
        <select id="alignment" class="form-select" aria-required="true" required>
          <option selected disabled hidden value="">Select an option...</option>
          <option>Neutral</option>
          <option>Other</option>
        </select>
      </div>
    </section>

    <hr>

    <h2>Armor Class and Hitpoints</h2>
    <section class="row">
      <div class="col-sm-6 mb-2">
        <label for="armor" class="form-label">Armor</label>
        <select id="armor" class="form-select" aria-required="true" required>
          <option selected disabled hidden value="">Select an option...</option>
          <option>Natural Armor</option>
          <option>Other</option>
        </select>

        <div class="form-check mt-1">
          <input class="form-check-input" type="checkbox" id="shield">
          <label class="form-check-label" for="shield">
            Shield
          </label>
        </div>
      </div>

      <!-- TODO: Update Armor Bonus automatically with Javascript -->
      <div class="col-sm-6 mb-2">
        <label for="armorBonus" class="form-label">Armor Bonus</label>
        <input type="number" class="form-control" id="armorBonus" value="0" aria-describedby="armorBonusHelpLabel" aria-readonly="true" readonly aria-required="true" required>
        <div id="armorBonusHelpLabel" class="form-text">
          Armor bonus updates automatically. For manual control, select <i>Natural Armor</i> or <i>Other</i>. <br>
          <strong>Not yet implemented</strong>
        </div>
      </div>

      <!-- TODO: Swap "readonly" attribute between HP and Hit Dice based on the value of the Custom HP checkbox with Javascript -->
      <div class="col-sm-6 mb-2">
        <label for="hitDice" class="form-label">Hit Dice</label>
        <input type="number" min="0" class="form-control" id="hitDice" aria-describedby="healthHelpLabel" aria-required="true" required>
        <div class="form-check mt-1">
          <input class="form-check-input" type="checkbox" id="customHP">
          <label class="form-check-label" for="customHP">
            Custom HP
          </label>
        </div>
      </div>

      <!-- TODO: Update Hitpoints (HP) automatically with Javascript -->
      <div class="col-sm-6 mb-2">
        <label for="health" class="form-label">Health Points</label>
        <input type="number" class="form-control" id="health" value="0" aria-describedby="healthHelpLabel" aria-readonly="true" readonly aria-required="true" required>
        <div id="healthHelpLabel" class="form-text">
          Health points are calculated automatically. For manual control, select <i>Custom HP</i>. <br>
          <strong>Not yet implemented</strong>
        </div>
      </div>
    </section>

    <hr>

    <h2>Movement</h2>
    <section class="row">
      <?php include '/opt/src/templates/monster-editor/speed.html'; ?>
      <?php include '/opt/src/templates/monster-editor/speed.html'; ?>
      <?php include '/opt/src/templates/monster-editor/speed.html'; ?>

      <div class="col-12 my-2 text-center">
        <button type="button" class="btn btn-success">New</button>
      </div>
    </section>

    <hr>

    <h2>Ability Scores</h2>
    <section>
      <div class="row mb-1 d-none d-sm-flex">
        <div class="align-items-center justify-content-center text-center 
        d-none col-5 offset-3 
        d-sm-flex col-sm-6 offset-sm-2">
          <label class="form-label">Score</label>
        </div>

        <div class="d-flex align-items-center justify-content-center text-center
        col-4
        col-sm-2">
          <label class="form-label">Modifier</label>
        </div>

        <div class="align-items-center justify-content-center text-center
        d-none col-auto offset-3 mb-2
        d-sm-flex col-sm-2 offset-sm-0 mb-sm-0">
          <label class="form-label">Saving Throw</label>
        </div>
      </div>

      <?php include '/opt/src/templates/monster-editor/ability-score.html'; ?>
      <?php include '/opt/src/templates/monster-editor/ability-score.html'; ?>
      <?php include '/opt/src/templates/monster-editor/ability-score.html'; ?>
      <?php include '/opt/src/templates/monster-editor/ability-score.html'; ?>
      <?php include '/opt/src/templates/monster-editor/ability-score.html'; ?>
      <?php include '/opt/src/templates/monster-editor/ability-score.html'; ?>
    </section>

    <hr>

    <h2>Attributes</h2>
    <section class="row gx-sm-5 gy-sm-3">
      <section class="col-sm-6 col-lg-4">
        <h3>Skill Proficiencies</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Skill Expertises</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Vulnerabilities</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Resistances</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Immunities</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Condition Immunities</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>
    </section>

    <hr>

    <h2>Senses and Languages</h2>
    <section class="row gx-sm-5 gy-sm-3">
      <section class="col-sm-6">
        <h3>Senses</h3>

        <div class="text-center mb-1">
          <input class="form-check-input" type="checkbox" id="">
          <label class="form-check-label" for="">Blind</label>
        </div>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/sense.html'; ?>
          <?php include '/opt/src/templates/monster-editor/sense.html'; ?>
          <?php include '/opt/src/templates/monster-editor/sense.html'; ?>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>

      <section class="col-sm-6">
        <h3>Languages</h3>

        <div class="row mb-2">
          <div class="col-sm-6 d-flex justify-content-start align-items-center">
            <label for="" class="form-label" style="margin-bottom:0;">Telepathy</label>
          </div>
          <div class="col-sm-6">
            <input type="number" min="0" step="5" class="form-control" id="" placeholder="0 ft">
          </div>
        </div>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>
    </section>

    <hr>

    <h2>Abilities</h2>
    <section>
      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
      </div>

      <div class="my-2 text-center">
        <button type="button" class="btn btn-success">New</button>
      </div>
    </section>

    <hr>

    <h2>Actions</h2>
    <section>
      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
      </div>

      <div class="my-2 text-center">
        <button type="button" class="btn btn-success">New</button>
      </div>
    </section>

    <hr>

    <h2>Bonus Actions</h2>
    <section>
      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
      </div>

      <div class="my-2 text-center">
        <button type="button" class="btn btn-success">New</button>
      </div>
    </section>

    <hr>

    <h2>Reactions</h2>
    <section>
      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
      </div>

      <div class="my-2 text-center">
        <button type="button" class="btn btn-success">New</button>
      </div>
    </section>

    <hr>

    <!-- TODO: Show / hide the legendary actions based on the Legendary Monster checkbox -->
    <h2>Legendary Features</h2>
    <section>
      <div class="text-center mb-1">
        <input class="form-check-input" type="checkbox" id="" style="border-width:1px; border-color:darkgray;">
        <label class="form-check-label" for=""><strong>Legendary Monster</strong></label>
      </div>

      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
      </div>

      <div class="my-2 text-center">
        <button type="button" class="btn btn-success">New</button>
      </div>
    </section>

    <hr>

    <h2>Challenge Rating</h2>
    <section class="row gy-2">
      <div class="col-sm-6 text-center">
        <div class="card py-3 d-flex content-align-center justify-content-center" style="min-height: 120px;">
          <div class="w-75 mx-auto mb-1">
            <input type="radio" class="btn-check" name="options-outlined" id="estimatedChallengeRadio" autocomplete="off" checked>
            <label class="btn btn-outline-success" for="estimatedChallengeRadio">Estimated Challenge Rating</label>
          </div>          
        
          <!-- TODO: Calculate estimated challenge rating with Javascript -->
          <p class="mb-0" style="font-size:x-large;">Challenge <span>1: 200XP</span></p>
        </div>
      </div>

      <div class="col-sm-6 text-center">
        <div class="card py-3 d-flex content-align-center justify-content-center" style="min-height: 120px;">
          <div class="w-75 mx-auto mb-1">
            <input type="radio" class="btn-check" name="options-outlined" id="customChallengeRadio" autocomplete="off">
            <label class="btn btn-outline-success" for="customChallengeRadio">Custom Challenge Rating</label>
          </div>
        
          <!-- <label for="size" class="form-label">Custom Challenge Rating</label> -->
          <select id="size" class="form-select w-50 mx-auto" aria-required="true" required>
            <option selected>Challenge 1: 200XP </option>
          </select>
        </div>
      </div>
    </section>

    <!-- TODO: Implement saving and exporting using AJAX / Javascript -->
    <div class="d-flex justify-content-center mt-4">
      <button type="button" class="btn btn-secondary me-2" style="min-width:100px; font-size:x-large;">Export</button>
      <button type="submit" class="btn btn-success ms-2" style="min-width:100px; font-size:x-large;">Save</button>
    </div>
  </form>


  <?php include '/opt/src/templates/footer.html'; ?>
  <?php include '/opt/src/templates/base-javascript.html'; ?>
  <script src="/js/monster-power-slider.js"></script>
  <script src="/js/monster-editor-validator.js"></script>
</body>

</html>