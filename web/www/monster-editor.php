<?php
$TITLE = "Monster Editor";
$AUTHOR = "Brennen Muller";
$DESCRIPTION = "Create and edit custom monsters for Dungeons & Dragons.";
$KEYWORDS = "dungeons and dragons, d&d, dnd, monster, creator, editor";

$LESS = ["styles/monster-editor.less"];
$SCRIPTS = ["js/monster-form-validator.js", "js/monster-form-update.js", "js/delete.js"];
?>

<?php
// USED TO GIVE UNIQUE ID NUMBERS TO EAC ELEMENT. PROBABLY NEEDS TO BE UPDATED LATER (ESPECIALLY TO ADD NEW ELEMENTS)
$UNIQUE_ID = 1;
?>

<!DOCTYPE html>
<html lang="en">

<?php include '/opt/src/templates/head.php'; ?>

<body>
  <?php include '/opt/src/templates/navbar.php'; ?>

  <header class="container">
    <h1>Monster Editor</h1>
    <hr>
  </header>

  <!-- Source: https://getbootstrap.com/docs/5.3/forms/overview/ -->
  <!-- Source: https://getbootstrap.com/docs/5.0/forms/validation/ -->
  <form class="container needs-validation" novalidate>
    <section class="row">
      <h2>General Information</h2>

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
          <option value="tiny">Tiny</option>
          <option value="small">Small</option>
          <option value="medium">Medium</option>
          <option value="large">Large</option>
          <option value="huge">Huge</option>
          <option value="gargantuan">Gargantuan</option>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="type" class="form-label">Type</label>
        <select id="type" class="form-select" aria-required="true" required>
          <option selected disabled hidden value="">Select an option...</option>
          <option value="aberration">Aberration</option>
          <option value="beast">Beast</option>
          <option value="celestial">Celestial</option>
          <option value="construct">Construct</option>
          <option value="dragon">Dragon</option>
          <option value="elemental">Elemental</option>
          <option value="fey">Fey</option>
          <option value="fiend">Fiend</option>
          <option value="giant">Giant</option>
          <option value="humanoid">Humanoid</option>
          <option value="monstrosity">Monstrosity</option>
          <option value="ooze">Ooze</option>
          <option value="plant">Plant</option>
          <option value="undead">Undead</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="alignment" class="form-label">Alignment</label>
        <select id="alignment" class="form-select" aria-required="true" required>
          <option selected disabled hidden value="">Select an option...</option>
          <option value="lawful good">Lawful Good</option>
          <option value="neutral good">Neutral Good</option>
          <option value="chaotic good">Chaotic Good</option>
          <option value="lawful neutral">Lawful Neutral</option>
          <option value="true neutral">True Neutral</option>
          <option value="chaotic neutral">Chaotic Neutral</option>
          <option value="lawful evil">Lawful Evil</option>
          <option value="neutral evil">Neutral Evil</option>
          <option value="chaotic evil">Chaotic Evil</option>
        </select>
      </div>
    </section>
    <hr>

    <section class="row">
      <h2>Armor Class and Hitpoints</h2>

      <div class="col-sm-6 mb-2">
        <label for="armor" class="form-label">Armor</label>
        <select id="armor" class="form-select" aria-required="true" required>
          <option selected disabled hidden value="">Select an option...</option>
          <option data-ac="10" data-type="light">None</option>
          <option data-ac="11" data-type="light">Padded</option>
          <option data-ac="11" data-type="light">Leather</option>
          <option data-ac="12" data-type="light">Studded Leather</option>

          <option data-ac="12" data-type="medium">Hide</option>
          <option data-ac="13" data-type="medium">Chain Shirt</option>
          <option data-ac="14" data-type="medium">Scale Mail</option>
          <option data-ac="14" data-type="medium">Spiked Armor</option>
          <option data-ac="14" data-type="medium">Breastplate</option>
          <option data-ac="15" data-type="medium">Halfplate</option>

          <option data-ac="14" data-type="heavy">Ring Mail</option>
          <option data-ac="16" data-type="heavy">Chain Mail</option>
          <option data-ac="17" data-type="heavy">Splint</option>
          <option data-ac="18" data-type="heavy">Plate</option>

          <option data-ac="0">Natural Armor</option>
          <option data-ac="0">Other</option>
        </select>

        <div class="form-check mt-1">
          <input class="form-check-input" type="checkbox" id="shield">
          <label class="form-check-label" for="shield">
            Shield
          </label>
        </div>
      </div>

      <div class="col-sm-6 mb-2">
        <label for="armorClass" class="form-label">Armor Class (AC)</label>
        <input type="number" class="form-control" id="armorClass" min="0" max="10" value="" aria-describedby="armorClassHelpLabel" aria-disabled="true" disabled>
        <div id="armorClassHelpLabel" class="form-text">
          Armor class updates automatically. For manual control, select <i>Natural Armor</i> or <i>Other</i>. <br>
        </div>
      </div>

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

      <div class="col-sm-6 mb-2">
        <label for="health" class="form-label">Health Points (HP)</label>
        <input type="number" class="form-control" id="health" min="1" value="1" aria-describedby="healthHelpLabel" aria-disabled="true" disabled>
        <div id="healthHelpLabel" class="form-text">
          Health points are calculated automatically. For manual control, select <i>Custom HP</i>. <br>
        </div>
      </div>
    </section>
    <hr>

    <section>
      <h2>Movement</h2>

      <?php include '/opt/src/templates/monster-editor/speed.php'; ?>
      <?php include '/opt/src/templates/monster-editor/speed.php'; ?>
      <?php include '/opt/src/templates/monster-editor/speed.php'; ?>

      <?php
      $NAME = "movement";
      $OPTIONS = ["Burrow Speed", "Climb Speed", "Fly Speed", "Swim Speed"];

      include '/opt/src/templates/monster-editor/add-many-button-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Ability Scores</h2>

      <div class="row mb-1 d-none d-sm-flex">
        <div class="align-items-center justify-content-center text-center 
        d-none col-5 offset-3 
        d-sm-flex col-sm-5 offset-sm-2">
          <label class="form-label">Score</label>
        </div>

        <div class="d-flex align-items-center justify-content-center text-center
        col-4
        col-sm-1">
          <label class="form-label">Modifier</label>
        </div>

        <!-- <div class="align-items-center justify-content-center text-center
        d-none col-auto offset-3 mb-2
        d-sm-flex col-sm-2 offset-sm-0 mb-sm-0">
          <label class="form-label">Saving Throw</label>
        </div> -->
      </div>

      <?php
      $IDS = ["strength", "dexterity", "constitution", "intelligence", "wisdom", "charisma"];
      foreach ($IDS as $ID) {
        include '/opt/src/templates/monster-editor/ability-score.php';
      }
      ?>
    </section>
    <hr>

    <section class="row gx-sm-5 gy-sm-3">
      <h2>Attributes</h2>

      <section class="col-sm-6 col-lg-4">
        <h3>Skill Proficiencies</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
        </div>

        <?php
        $NAME = "skill";
        $OPTIONS = [
          "Athletics",

          "Acrobatics",
          "Sleight of Hand",
          "Stealth",

          "Arcana",
          "History",
          "Investigation",
          "Nature",
          "Religion",

          "Animal Handling",
          "Insight",
          "Medicine",
          "Perception",
          "Survival",

          "Deception",
          "Intimidation",
          "Performance",
          "Persuasion",
        ];
        sort($OPTIONS);

        include '/opt/src/templates/monster-editor/add-many-button-modal.php';
        ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Skill Expertises</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
        </div>

        <?php
        $NAME = "skill";
        $OPTIONS = [
          "Athletics",

          "Acrobatics",
          "Sleight of Hand",
          "Stealth",

          "Arcana",
          "History",
          "Investigation",
          "Nature",
          "Religion",

          "Animal Handling",
          "Insight",
          "Medicine",
          "Perception",
          "Survival",

          "Deception",
          "Intimidation",
          "Performance",
          "Persuasion",
        ];
        sort($OPTIONS);

        include '/opt/src/templates/monster-editor/add-many-button-modal.php';
        ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Vulnerabilities</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
        </div>

        <?php
        $NAME = "damageType";
        $OPTIONS = [
          "Acid",
          "Bludgeoning",
          "Cold",
          "Fire",
          "Force",
          "Lightning",
          "Necrotic",
          "Piercing",
          "Poison",
          "Psychic",
          "Radiant",
          "Slashing",
          "Thunder",

          "Non-Magical",
          "Magical",
          "Non-Silvered",
          "Non-Adamantine"
        ];

        include '/opt/src/templates/monster-editor/add-many-button-modal.php';
        ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Resistances</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
        </div>

        <?php
        $NAME = "damageType";
        $OPTIONS = [
          "Acid",
          "Bludgeoning",
          "Cold",
          "Fire",
          "Force",
          "Lightning",
          "Necrotic",
          "Piercing",
          "Poison",
          "Psychic",
          "Radiant",
          "Slashing",
          "Thunder",

          "Non-Magical",
          "Magical",
          "Non-Silvered",
          "Non-Adamantine"
        ];

        include '/opt/src/templates/monster-editor/add-many-button-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Immunities</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
        </div>

        <?php
        $NAME = "damageType";
        $OPTIONS = [
          "Acid",
          "Bludgeoning",
          "Cold",
          "Fire",
          "Force",
          "Lightning",
          "Necrotic",
          "Piercing",
          "Poison",
          "Psychic",
          "Radiant",
          "Slashing",
          "Thunder",

          "Non-Magical",
          "Magical",
          "Non-Silvered",
          "Non-Adamantine"
        ];

        include '/opt/src/templates/monster-editor/add-many-button-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Condition Immunities</h3>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
        </div>

        <?php
        $NAME = "condition";
        $OPTIONS = [
          "Blinded",
          "Charmed",
          "Deafened",
          "Frightened",
          "Grappled",
          "Incapacitated",
          "Invisible",
          "Paralyzed",
          "Petrified",
          "Poisoned",
          "Prone",
          "Restrained",
          "Stunned",
          "Unconscious",
          "Exhaustion",
        ];
        sort($OPTIONS);

        include '/opt/src/templates/monster-editor/add-many-button-modal.php'; ?>
      </section>
    </section>
    <hr>

    <section class="row gx-sm-5 gy-sm-3">
      <h2>Senses and Languages</h2>

      <section class="col-sm-6">
        <h3>Senses</h3>

        <div class="text-center mb-1">
          <input class="form-check-input" type="checkbox" id="blind">
          <label class="form-check-label" for="blinc">Blind</label>
        </div>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/sense.php'; ?>
          <?php include '/opt/src/templates/monster-editor/sense.php'; ?>
          <?php include '/opt/src/templates/monster-editor/sense.php'; ?>
        </div>

        <?php
        $NAME = "sense";
        $OPTIONS = [
          "Blindsight",
          "Darkvision",
          "Tremorsense",
          "Truesight"
        ];

        include '/opt/src/templates/monster-editor/add-many-button-modal.php';
        ?>
      </section>

      <section class="col-sm-6">
        <h3>Languages</h3>

        <div class="row mb-2">
          <div class="col-sm-6 d-flex justify-content-start align-items-center">
            <label for="telepathy" class="form-label" style="margin-bottom:0;">Telepathy</label>
          </div>
          <div class="col-sm-6">
            <input type="number" min="0" step="5" class="form-control" id="telepathy" placeholder="0 ft">
          </div>
        </div>

        <div class="d-flex flex-column">
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
          <?php include '/opt/src/templates/monster-editor/attribute.php'; ?>
        </div>

        <?php
        $NAME = "language";
        $OPTIONS = [
          "Common",
          "Dwarvish",
          "Elvish",
          "Giant",
          "Gnomish",
          "Goblin",
          "Halfling",
          "Orc",

          "Abyssal",
          "Aquan",
          "Auran",
          "Celestial",
          "Draconic",
          "Deep Speech",
          "Ignan",
          "Infernal",
          "Primoridal",
          "Sylvan",
          "Terran",
          "Undercommon"
        ];

        include '/opt/src/templates/monster-editor/add-many-button-modal.php';
        ?>
      </section>
    </section>
    <hr>

    <section>
      <h2>Abilities</h2>

      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
      </div>

      <?php
      $NAME = "ability";
      $OPTIONS = [
        "Multiattack",
        "Spellcasting",
        "Innate Spellcasting",

        "Custom"
      ];

      include '/opt/src/templates/monster-editor/add-single-button-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Actions</h2>

      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
      </div>

      <?php
      $NAME = "action";
      $OPTIONS = [
        "Melee Weapon Attack",
        "Ranged Weapon Attack",

        "Custom"
      ];

      include '/opt/src/templates/monster-editor/add-single-button-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Bonus Actions</h2>

      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
      </div>

      <?php
      $NAME = "bonusAction";
      $OPTIONS = [
        "Melee Weapon Attack",
        "Ranged Weapon Attack",

        "Custom"
      ];

      include '/opt/src/templates/monster-editor/add-single-button-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Reactions</h2>
      <div class="row gx-sm-5 gy-sm-3">
        <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
        <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
      </div>

      <div class="my-2 text-center">
        <button type="button" class="btn btn-success">New</button>
      </div>

      <?php
      // $NAME = "reaction";
      // $OPTIONS = [
      //    "Custom"
      // ];

      // include '/opt/src/templates/monster-editor/add-single-button-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Legendary Features</h2>
      <div class="text-center mb-1">
        <input class="form-check-input" type="checkbox" id="legendaryCheckbox" style="border-width:1px; border-color:darkgray;">
        <label class="form-check-label" for="legendaryCheckbox"><strong>Legendary Monster</strong></label>
      </div>

      <div id="legendaryBlock" style="display:none">
        <div class="row gx-sm-5 gy-sm-3">
          <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
          <?php include '/opt/src/templates/monster-editor/ability-action.php'; ?>
        </div>

        <?php
        $NAME = "legendaryAbility";
        $OPTIONS = [
          "Legendary Resistance",

          "Custom"
        ];

        include '/opt/src/templates/monster-editor/add-single-button-modal.php';
        ?>
      </div>
    </section>
    <hr>

    <section class="row gy-2">
      <h2>Challenge Rating</h2>

      <div class="col-sm-6 text-center">
        <div class="card py-3 d-flex content-align-center justify-content-center" style="min-height: 120px;">
          <div class="w-75 mx-auto mb-1">
            <input type="radio" class="btn-check" name="options-outlined" id="estimatedChallengeRadio" checked>
            <label class="btn btn-outline-success" for="estimatedChallengeRadio">Estimated Challenge Rating</label>
          </div>

          <p class="mb-0" style="font-size:x-large;">Challenge <span>1: 200XP</span></p>
        </div>
      </div>

      <div class="col-sm-6 text-center">
        <div class="card py-3 d-flex content-align-center justify-content-center" style="min-height: 120px;">
          <div class="w-75 mx-auto mb-1">
            <input type="radio" class="btn-check" name="options-outlined" id="customChallengeRadio">
            <label class="btn btn-outline-success" for="customChallengeRadio">Custom Challenge Rating</label>
          </div>

          <select id="CRSelect" class="form-select w-50 mx-auto" aria-label="Custom challenge rating">
            <option selected>Challenge 0: 10XP </option>
            <option>Challenge 1/8: 25XP </option>
            <option>Challenge 1/4: 50XP </option>
            <option>Challenge 1/2: 100XP </option>
            <option>Challenge 1: 200XP </option>
            <option>Challenge 2: 450XP </option>
            <option>Challenge 3: 700XP </option>
            <option>Challenge 4: 1,100XP </option>
            <option>Challenge 5: 1,800XP </option>
            <option>Challenge 6: 2,300XP </option>
            <option>Challenge 7: 2,900XP </option>
            <option>Challenge 8: 3,900XP </option>
            <option>Challenge 9: 5,000XP </option>
            <option>Challenge 10: 5,900XP </option>
            <option>Challenge 11: 7,200XP </option>
            <option>Challenge 12: 8,400XP </option>
            <option>Challenge 13: 10,000XP </option>
            <option>Challenge 14: 11,500XP </option>
            <option>Challenge 15: 13,000XP </option>
            <option>Challenge 16: 15,000XP </option>
            <option>Challenge 17: 18,000XP </option>
            <option>Challenge 18: 20,000XP </option>
            <option>Challenge 19: 22,000XP </option>
            <option>Challenge 20: 25,000XP </option>
            <option>Challenge 21: 33,000XP </option>
            <option>Challenge 22: 41,000XP </option>
            <option>Challenge 23: 50,000XP </option>
            <option>Challenge 24: 62,000XP </option>
            <option>Challenge 25: 75,000XP </option>
            <option>Challenge 26: 90,000XP </option>
            <option>Challenge 27: 105,000XP </option>
            <option>Challenge 28: 120,000XP </option>
            <option>Challenge 29: 135,000XP </option>
            <option>Challenge 30: 155,000XP </option>
          </select>
        </div>
      </div>
    </section>

    <div class="d-flex justify-content-center mt-4">
      <button type="button" class="btn btn-secondary me-2" style="min-width:100px; font-size:x-large;">Export</button>
      <button type="submit" class="btn btn-success ms-2" style="min-width:100px; font-size:x-large;">Save</button>
    </div>
  </form>

  <?php include '/opt/src/templates/footer.php'; ?>
  <?php include '/opt/src/templates/javascript.php'; ?>
</body>

</html>