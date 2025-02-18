<!DOCTYPE html>
<html lang="en">

<!-- https://www.w3schools.com/PHP/php_includes.asp -->
<?php include '/opt/src/templates/base.html'; ?>

<body>
  <?php include '/opt/src/templates/navbar.html'; ?>
  <header class="container text-center">
    <h1>Monster Editor</h1>
    <hr>
  </header>

  <!-- https://getbootstrap.com/docs/5.3/forms/overview/ -->
  <form class="container">
    <section>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="name" placeholder="None"> <!-- aria-describedby="HelpLabel"> -->
        <label for="name" class="form-label">Name</label>
        <!-- <div id="HelpLabel" class="form-text">Tips or instructions go here...</div> -->
      </div>

      <div class="mb-3">
        <label for="size" class="form-label">Size</label>
        <select id="size" class="form-select">
          <option>Select an option...</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select id="type" class="form-select">
          <option>Select an option...</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="alignment" class="form-label">Alignment</label>
        <select id="alignment" class="form-select">
          <option>Select an option...</option>
        </select>
      </div>

      <hr>
    </section>

    <section>
      <div class="mb-3">
        <label for="armor" class="form-label">Armor</label>
        <select id="armor" class="form-select">
          <option>Select an option...</option>
          <option>Custom</option>
        </select>

        <div class="form-check mt-1">
          <input class="form-check-input" type="checkbox" id="shield">
          <label class="form-check-label" for="shield">
            Shield
          </label>
        </div>

        <div class="mt-2">
          <label for="armorBonus" class="form-label">Armor Bonus</label>
          <input type="text" class="form-control" id="armorBonus" placeholder="0" aria-describedby="armorBonusHelpLabel" disabled>
          <div id="armorBonusHelpLabel" class="form-text">
            Armor bonuses update automatically. For manual control, select <i>Custom</i>. <br>
            <strong>Not yet implemented</strong>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="health" class="form-label">Hit Dice</label>
        <input type="text" class="form-control" id="health" placeholder="0" aria-describedby="healthHelpLabel">
        
        <div class="form-check mt-1">
          <input class="form-check-input" type="checkbox" id="customHP">
          <label class="form-check-label" for="customHP">
            Custom
          </label>
        </div>

        <div id="healthHelpLabel" class="form-text">
          Health points are calculated automatically. For manual control, select <i>Custom</i>. <br>
          <strong>Not yet implemented</strong>
        </div>
      </div>

      <hr>
    </section>
  </form>


  <?php include '/opt/src/templates/footer.html'; ?>
  <?php include '/opt/src/templates/base-javascript.html'; ?>
</body>
</html>