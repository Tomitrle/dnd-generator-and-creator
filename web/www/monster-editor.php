<!DOCTYPE html>
<html lang="en">

<!-- https://www.w3schools.com/PHP/php_includes.asp -->
<?php include '/opt/src/templates/base.html'; ?>

<body>
  <style>
    h2, h3, h4, h5, h6 {
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
  </style>

  <?php include '/opt/src/templates/navbar.html'; ?>

  <header class="container text-center">
    <h1>Monster Editor</h1>
  </header>

  <hr>

  <!-- <div class="form-floating mb-3">
    <input type="text" class="form-control" id="name" placeholder="None" aria-describedby="HelpLabel">
    <label for="name" class="form-label">Name</label>
    <div id="HelpLabel" class="form-text">Tips or instructions go here...</div>
  </div> -->

  <!-- https://getbootstrap.com/docs/5.3/forms/overview/ -->
  <form class="container">

    <h2>General Information</h2>
    <section class="row">
      <div class="col-sm-6 mb-2">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" aria-describedby="HelpLabel">
      </div>

      <!-- https://stackoverflow.com/questions/3518002/how-can-i-set-the-default-value-for-an-html-select-element -->
      <div class="col-sm-6 mb-2">
        <label for="size" class="form-label">Size</label>
        <select id="size" class="form-select">
          <option selected disabled hidden>Select an option...</option>
          <option>Medium</option>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="type" class="form-label">Type</label>
        <select id="type" class="form-select">
          <option selected disabled hidden>Select an option...</option>
          <option>Humanoid</option>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="alignment" class="form-label">Alignment</label>
        <select id="alignment" class="form-select">
          <option selected disabled hidden>Select an option...</option>
          <option>Neutral</option>
        </select>
      </div>
    </section>

    <hr>

    <h2>Armor Class and Hitpoints</h2>
    <section class="row">
      <div class="col-sm-6 mb-2">
        <label for="armor" class="form-label">Armor</label>
        <select id="armor" class="form-select">
          <option selected disabled hidden>Select an option...</option>
          <option>Custom</option>
        </select>

        <div class="form-check mt-1">
          <input class="form-check-input" type="checkbox" id="shield">
          <label class="form-check-label" for="shield">
            Shield
          </label>
        </div>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="armorBonus" class="form-label">Armor Bonus</label>
        <input type="number" class="form-control" id="armorBonus" value="0" aria-describedby="armorBonusHelpLabel" aria-readonly="true" readonly>
        <div id="armorBonusHelpLabel" class="form-text">
          Armor bonus updates automatically. For manual control, select <i>Custom</i>. <br>
          <strong>Not yet implemented</strong>
        </div>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="hitDice" class="form-label">Hit Dice</label>
        <input type="number" class="form-control" id="hitDice" placeholder="0" aria-describedby="healthHelpLabel">
        <div class="form-check mt-1">
          <input class="form-check-input" type="checkbox" id="customHP">
          <label class="form-check-label" for="customHP">
            Custom HP
          </label>
        </div>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="health" class="form-label">Health Points</label>
        <input type="number" class="form-control" id="health" value="0" aria-describedby="healthHelpLabel" aria-readonly="true" readonly>
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

      <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
      <div class="col-12 form-text text-center">
        <strong>Not yet implemented</strong>
      </div>

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

      <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
      <div class="mt-2 form-text text-center">
        <strong>Not yet implemented</strong>
      </div>
    </section>

    <hr>

    <h2>Attributes</h2>
    <section class="row g-3 g-sm-5">
      <section class="col-sm-6 col-lg-4">
        <h3>Skill Proficiencies</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.html'; ?>
        </div>

        <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
        <div class="col-12 form-text text-center">
          <strong>Not yet implemented</strong>
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

        <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
        <div class="col-12 form-text text-center">
          <strong>Not yet implemented</strong>
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

        <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
        <div class="col-12 form-text text-center">
          <strong>Not yet implemented</strong>
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

        <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
        <div class="col-12 form-text text-center">
          <strong>Not yet implemented</strong>
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

        <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
        <div class="col-12 form-text text-center">
          <strong>Not yet implemented</strong>
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

        <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
        <div class="col-12 form-text text-center">
          <strong>Not yet implemented</strong>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>
    </section>
  </form>


  <?php include '/opt/src/templates/footer.html'; ?>
  <?php include '/opt/src/templates/base-javascript.html'; ?>
</body>

</html>