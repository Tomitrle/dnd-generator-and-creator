<?php
$TITLE = "Monster Editor";
$AUTHOR = "Brennen Muller";
$DESCRIPTION = "Create and edit custom monsters for Dungeons & Dragons.";
$KEYWORDS = "dungeons and dragons, d&d, dnd, monster, creator, editor";

$LESS = ["styles/monster-editor.less"];
$SCRIPTS = ["js/monster-editor.js"];
?>

<?php
// USED TO GIVE UNIQUE ID NUMBERS TO EACH ELEMENT. PROBABLY NEEDS TO BE UPDATED LATER (ESPECIALLY TO ADD NEW ELEMENTS)
$UNIQUE_ID = 1;
$CATEGORY = "";
$OPTIONS = "";
?>

<!DOCTYPE html>
<html lang="en">
<?php require '/opt/src/templates/head.php'; ?>

<body>
  <?php require '/opt/src/templates/navbar.php'; ?>

  <header class="container">
    <h1>Monster Editor</h1>
    <hr>
  </header>

  <?php require '/opt/src/templates/alerts.php'; ?>

  <!-- Source: https://getbootstrap.com/docs/5.3/forms/overview/ -->
  <!-- Source: https://getbootstrap.com/docs/5.0/forms/validation/ -->
  <form class="container needs-validation" action="monster-editor.php" method="post" novalidate>
    <section class="row">
      <h2>General Information</h2>
      <div class="col-sm-6 mb-2">
        <label class="form-label" for="name">Name</label>
        <input id="name" name="name" class="form-control" type="text" pattern="[\w\s]+" aria-required="true" required>
      </div>

      <!-- Source: https://stackoverflow.com/questions/3518002/how-can-i-set-the-default-value-for-an-html-select-element -->
      <!-- Source: https://stackoverflow.com/questions/13766015/is-it-possible-to-configure-a-required-field-to-ignore-white-space -->
      <div class="col-sm-6 mb-2">
        <label class="form-label" for="size">Size</label>
        <select id="size" name="size" class="form-select" aria-required="true" required>
          <option selected disabled hidden>Select an option...</option>
          <option>Tiny</option>
          <option>Small</option>
          <option>Medium</option>
          <option>Large</option>
          <option>Huge</option>
          <option>Gargantuan</option>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="type">Type</label>
        <select id="type" name="type" class="form-select" aria-required="true" required>
          <option selected disabled hidden>Select an option...</option>
          <option>Aberration</option>
          <option>Beast</option>
          <option>Celestial</option>
          <option>Construct</option>
          <option>Dragon</option>
          <option>Elemental</option>
          <option>Fey</option>
          <option>Fiend</option>
          <option>Giant</option>
          <option>Humanoid</option>
          <option>Monstrosity</option>
          <option>Ooze</option>
          <option>Plant</option>
          <option>Undead</option>
          <option>Other</option>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="alignment">Alignment</label>
        <select id="alignment" name="alignment" class="form-select" aria-required="true" required>
          <option selected disabled hidden>Select an option...</option>
          <option>Lawful Good</option>
          <option>Neutral Good</option>
          <option>Chaotic Good</option>
          <option>Lawful Neutral</option>
          <option>True Neutral</option>
          <option>Chaotic Neutral</option>
          <option>Lawful Evil</option>
          <option>Neutral Evil</option>
          <option>Chaotic Evil</option>
        </select>
      </div>
    </section>
    <hr>

    <section class="row">
      <h2>Armor Class and Hitpoints</h2>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="armor">Armor</label>
        <select id="armor" name="armor" class="form-select" aria-required="true" required>
          <option selected disabled hidden>Select an option...</option>
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
          <input id="shield" name="shield" class="form-check-input" type="checkbox">
          <label class="form-check-label" for="shield">
            Shield
          </label>
        </div>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="armorClass">Armor Class (AC)</label>
        <input id="armorClass" name="armorClass" class="form-control" type="number" min="0" max="30" aria-describedby="armorClassHelpLabel" aria-disabled="true" disabled>
        <div id="armorClassHelpLabel" class="form-text">
          Armor class updates automatically. For manual control, select <i>Natural Armor</i> or <i>Other</i>. <br>
        </div>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="hitDice">Hit Dice</label>
        <input id="hitDice" name="hitDice" class="form-control" type="number" min="0" max="1000" aria-describedby="healthHelpLabel" aria-required="true" required>
        <div class="form-check mt-1">
          <input id="customHP" name="customHP" class="form-check-input" type="checkbox">
          <label class="form-check-label" for="customHP">
            Custom HP
          </label>
        </div>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="health">Health Points (HP)</label>
        <input id="health" name="health" class="form-control" type="number" min="1" value="1" aria-describedby="healthHelpLabel" aria-disabled="true" disabled>
        <div id="healthHelpLabel" class="form-text">
          Health points are calculated automatically. For manual control, select <i>Custom HP</i>. <br>
        </div>
      </div>
    </section>
    <hr>

    <section>
      <h2>Movement</h2>
      <?php
      //#MARK: MOVEMENT
      $CATEGORY = "speed";
      $OPTIONS = ["Burrow Speed", "Climb Speed", "Fly Speed", "Swim Speed"];
      ?>

      <div class="row">
        <div class="col-sm-2 mb-1 d-flex justify-content-sm-center align-items-center">
          <label class="form-label" for="speedRange" style="margin-bottom:0;">Speed</label>
        </div>
        <div class="col-sm-9 col-11 mb-1">
          <input id="speedRange" name="speedRange" class="form-control" type="number" min="0" step="5" placeholder="0 ft" aria-required="true" required>
        </div>
      </div>

      <div id="<?php echo $CATEGORY; ?>Container"></div>

      <?php require '/opt/src/templates/monster-editor/attribute-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Ability Scores</h2>

      <div class="row mb-1 d-none d-sm-flex">
        <div class="align-items-center justify-content-center text-center   d-none col-5 offset-3   d-sm-flex col-sm-5 offset-sm-2">
          <label class="form-label">Score</label>
        </div>

        <div class="d-flex align-items-center justify-content-center text-center   col-4   col-sm-1">
          <label class="form-label">Modifier</label>
        </div>

        <!-- <div class="align-items-center justify-content-center text-center
        d-none col-auto offset-3 mb-2
        d-sm-flex col-sm-2 offset-sm-0 mb-sm-0">
          <label class="form-label">Saving Throw</label>
        </div> -->
      </div>

      <?php
      //#MARK: ABILITY SCORES
      foreach (["strength", "dexterity", "constitution", "intelligence", "wisdom", "charisma"] as $CATEGORY) {
        require '/opt/src/templates/monster-editor/attributes/ability-score.php';
      }
      ?>
    </section>
    <hr>

    <section class="row gx-sm-5 gy-sm-3">
      <h2>Attributes</h2>

      <section class="col-sm-6 col-lg-4">
        <h3>Skill Proficiencies</h3>
        <?php
        //#MARK: SKILL PROFICIENCIES
        $CATEGORY = "skillProficiency";
        $OPTIONS = [
          "Acrobatics",
          "Animal Handling",
          "Arcana",
          "Athletics",
          "Deception",
          "History",
          "Insight",
          "Intimidation",
          "Investigation",
          "Medicine",
          "Nature",
          "Perception",
          "Performance",
          "Persuasion",
          "Religion",
          "Sleight of Hand",
          "Stealth",
          "Survival",
        ];
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>

        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Skill Expertises</h3>
        <?php
        //#MARK: SKILL EXPERTISES
        $CATEGORY = "skillExpertise";
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>

        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Vulnerabilities</h3>
        <?php
        //#MARK: DAMAGE VULNERABILITIES
        $CATEGORY = "damageVulnerability";
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
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>

        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Resistances</h3>
        <?php
        //#MARK: DAMAGE RESISTANCES
        $CATEGORY = "damageResistance";
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>

        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Immunities</h3>
        <?php
        // #MARK: DAMAGE IMMUNITIES
        $CATEGORY = "damageImmunity";
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>

        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Condition Immunities</h3>
        <?php
        // #MARK: CONDITION IMMUNITIES
        $CATEGORY = "conditionImmunity";
        $OPTIONS = [
          "Blinded",
          "Charmed",
          "Deafened",
          "Exhaustion",
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
        ];
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>

        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>
    </section>
    <hr>

    <section class="row gx-sm-5 gy-sm-3">
      <h2>Senses and Languages</h2>

      <section class="col-sm-6">
        <h3>Senses</h3>
        <?php
        // #MARK: SENSES
        $CATEGORY = "sense";
        $OPTIONS = [
          "Blindsight",
          "Darkvision",
          "Tremorsense",
          "Truesight"
        ];
        ?>

        <div class="text-center mb-1">
          <input id="blind" name="blind" class="form-check-input" type="checkbox">
          <label class="form-check-label" for="blind">Blind</label>
        </div>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>

        <?php require '/opt/src/templates/monster-editor/attribute-modal.php';
        ?>
      </section>

      <section class="col-sm-6">
        <h3>Languages</h3>
        <?php
        // #MARK: LANGUAGES
        $CATEGORY = "language";
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
        ?>

        <div class="row mb-2">
          <div class="col-sm-6 d-flex justify-content-start align-items-center">
            <label class="form-label" for="telepathy" style="margin-bottom:0;">Telepathy</label>
          </div>
          <div class="col-sm-6">
            <input id="telepathy" name="telepathy" class="form-control" type="number" min="0" step="5" placeholder="0 ft">
          </div>
        </div>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>

        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>
    </section>
    <hr>

    <section>
      <h2>Abilities</h2>
      <?php
      // #MARK: ABILITIES
      $CATEGORY = "ability";
      $OPTIONS = [
        "Multiattack",
        "Spellcasting",
        "Innate Spellcasting",

        "Custom"
      ];
      ?>

      <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>

      <?php require '/opt/src/templates/monster-editor/attribute-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Actions</h2>
      <?php
      // #MARK: ACTIONS
      $CATEGORY = "action";
      $OPTIONS = [
        "Melee Weapon Attack",
        "Ranged Weapon Attack",

        "Custom"
      ];
      ?>

      <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>

      <?php require '/opt/src/templates/monster-editor/attribute-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Bonus Actions</h2>
      <?php
      // #MARK: BONUS ACTIONS
      $CATEGORY = "bonusAction";
      $OPTIONS = [
        "Melee Weapon Attack",
        "Ranged Weapon Attack",

        "Custom"
      ];
      ?>

      <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>

      <?php require '/opt/src/templates/monster-editor/attribute-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Reactions</h2>

      <?php
      // #MARK: REACTIONS
      $CATEGORY = "reaction";
      $OPTIONS = [
         "Custom"
      ];
      ?>

      <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>

      <?php require '/opt/src/templates/monster-editor/attribute-modal.php';
      ?>
    </section>
    <hr>

    <section>
      <h2>Legendary Features</h2>
      <?php
      // #MARK: LEGENDARY
      $CATEGORY = "legendaryAbility";
      $OPTIONS = [
        "Legendary Resistance",

        "Custom"
      ];
      ?>

      <div class="text-center mb-1">
        <input id="legendaryCheckbox" name="legendaryCheckbox" class="form-check-input" type="checkbox" style="border-width:1px; border-color:darkgray;">
        <label class="form-check-label" for="legendaryCheckbox"><strong>Legendary Monster</strong></label>
      </div>

      <div id="legendaryBlock" style="display:none">
        <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>

        <?php require '/opt/src/templates/monster-editor/attribute-modal.php';
        ?>
      </div>
    </section>
    <hr>

    <section class="row gy-2">
      <h2>Challenge Rating</h2>

      <div class="col-sm-6 text-center">
        <div class="card py-3 d-flex content-align-center justify-content-center" style="min-height: 120px;">
          <div class="w-75 mx-auto mb-1">
            <input id="estimatedChallengeRadio" name="challengeRadio" class="btn-check" type="radio" value="estimated" checked>
            <label class="btn btn-outline-success" for="estimatedChallengeRadio">Estimated Challenge Rating</label>
          </div>

          <input type="hidden" id="estimatedChallengeRating" name="estimatedChallengeRating" value="1">
          <p class="mb-0" style="font-size:x-large;">Challenge <span>1: 200XP</span></p>
        </div>
      </div>

      <div class="col-sm-6 text-center">
        <div class="card py-3 d-flex content-align-center justify-content-center" style="min-height: 120px;">
          <div class="w-75 mx-auto mb-1">
            <input id="customChallengeRadio" name="challengeRadio" class="btn-check" type="radio" value="custom">
            <label class="btn btn-outline-success" for="customChallengeRadio">Custom Challenge Rating</label>
          </div>

          <select id="challengeRatingSelect" name="challengeRatingSelect" class="form-select w-50 mx-auto" aria-label="Custom challenge rating">
            <option selected value="0">Challenge 0: 10XP </option>
            <option value="1/8">Challenge 1/8: 25XP </option>
            <option value="1/4">Challenge 1/4: 50XP </option>
            <option value="1/2">Challenge 1/2: 100XP </option>
            <option value="1">Challenge 1: 200XP </option>
            <option value="2">Challenge 2: 450XP </option>
            <option value="3">Challenge 3: 700XP </option>
            <option value="4">Challenge 4: 1,100XP </option>
            <option value="5">Challenge 5: 1,800XP </option>
            <option value="6">Challenge 6: 2,300XP </option>
            <option value="7">Challenge 7: 2,900XP </option>
            <option value="8">Challenge 8: 3,900XP </option>
            <option value="9">Challenge 9: 5,000XP </option>
            <option value="10">Challenge 10: 5,900XP </option>
            <option value="11">Challenge 11: 7,200XP </option>
            <option value="12">Challenge 12: 8,400XP </option>
            <option value="13">Challenge 13: 10,000XP </option>
            <option value="14">Challenge 14: 11,500XP </option>
            <option value="15">Challenge 15: 13,000XP </option>
            <option value="16">Challenge 16: 15,000XP </option>
            <option value="17">Challenge 17: 18,000XP </option>
            <option value="18">Challenge 18: 20,000XP </option>
            <option value="19">Challenge 19: 22,000XP </option>
            <option value="20">Challenge 20: 25,000XP </option>
            <option value="21">Challenge 21: 33,000XP </option>
            <option value="22">Challenge 22: 41,000XP </option>
            <option value="23">Challenge 23: 50,000XP </option>
            <option value="24">Challenge 24: 62,000XP </option>
            <option value="25">Challenge 25: 75,000XP </option>
            <option value="26">Challenge 26: 90,000XP </option>
            <option value="27">Challenge 27: 105,000XP </option>
            <option value="28">Challenge 28: 120,000XP </option>
            <option value="29">Challenge 29: 135,000XP </option>
            <option value="30">Challenge 30: 155,000XP </option>
          </select>
        </div>
      </div>
    </section>

    <div class="d-flex justify-content-center mt-4">
      <button class="btn btn-secondary me-2" type="button" style="min-width:100px; font-size:x-large;">Export</button>
      <button id="saveButton" class="btn btn-success ms-2" type="submit" style="min-width:100px; font-size:x-large;">Save</button>
    </div>

    <input id="IDCounter" type="hidden" value="<?php echo $UNIQUE_ID; ?>">
  </form>

  <?php require '/opt/src/templates/footer.php'; ?>
  <?php require '/opt/src/templates/javascript.php'; ?>
</body>

</html>