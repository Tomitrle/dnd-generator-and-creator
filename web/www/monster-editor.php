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
        <input type="text" class="form-control" id="name">
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
    <section class="row gx-sm-5 gy-sm-3">
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

        <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
        <div class="col-12 form-text text-center">
          <strong>Not yet implemented</strong>
        </div>

        <div class="col-12 my-2 text-center">
          <button type="button" class="btn btn-success">New</button>
        </div>
      </section>

      <section class="col-sm-6">
        <h3>Languages</h3>

        <div class="row mb-1">
          <div class="col-sm-3 d-flex justify-content-sm-center align-items-center">
            <label for="" class="form-label" style="margin-bottom:0;">Telepathy</label>
          </div>
          <div class="col-sm-9">
            <input type="number" class="form-control" id="" placeholder="0 ft" value="0">
          </div>
        </div>

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

    <hr>

    <h2>Abilities</h2>
    <section>
      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.html'; ?>
      </div>

      <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
      <div class="form-text text-center">
        <strong>Not yet implemented</strong>
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

      <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
      <div class="form-text text-center">
        <strong>Not yet implemented</strong>
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

      <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
      <div class="form-text text-center">
        <strong>Not yet implemented</strong>
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

      <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
      <div class="form-text text-center">
        <strong>Not yet implemented</strong>
      </div>

      <div class="my-2 text-center">
        <button type="button" class="btn btn-success">New</button>
      </div>
    </section>

    <hr>

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

      <!-- TODO: Update the IDs and textfor each list element dynamically. Probably can be done with PHP -->
      <div class="form-text text-center">
        <strong>Not yet implemented</strong>
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
        
          <p class="mb-0" style="font-size:x-large;">Challenge 1: 200XP
          </p>
        </div>
      </div>

      <div class="col-sm-6 text-center">
        <div class="card py-3 d-flex content-align-center justify-content-center" style="min-height: 120px;">
          <div class="w-75 mx-auto mb-1">
            <input type="radio" class="btn-check" name="options-outlined" id="customChallengeRadio" autocomplete="off">
            <label class="btn btn-outline-success" for="customChallengeRadio">Custom Challenge Rating</label>
          </div>
        
          <!-- <label for="size" class="form-label">Custom Challenge Rating</label> -->
          <select id="size" class="form-select w-50 mx-auto">
            <option selected disabled hidden>Select an option...</option>
            <option>Challenge 1: 200XP </option>
          </select>
        </div>
      </div>
    </section>


  </form>


  <?php include '/opt/src/templates/footer.html'; ?>
  <?php include '/opt/src/templates/base-javascript.html'; ?>
</body>

</html>