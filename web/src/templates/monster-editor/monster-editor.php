<?php

/**
 * Sources
 * https://getbootstrap.com/docs/5.3/forms/overview/
 * https://getbootstrap.com/docs/5.0/forms/validation/
 * https://stackoverflow.com/questions/3518002/how-can-i-set-the-default-value-for-an-html-select-element
 * https://stackoverflow.com/questions/13766015/is-it-possible-to-configure-a-required-field-to-ignore-white-space
 */

$TITLE = "Monster Editor";
$AUTHOR = "Brennen Muller";
$DESCRIPTION = "Create and edit custom monsters for Dungeons & Dragons.";
$KEYWORDS = "dungeons and dragons, d&d, dnd, monster, creator, editor";

$LESS = ["styles/monster-editor.less"];
$SCRIPTS = ["js/monster-editor.js"];

$UNIQUE_ID = 1;
$OPTIONS = json_decode(file_get_contents("{$GLOBALS['src']}/data/monster-options.json"), true);
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

  <form class="container needs-validation" action="monster-editor.php?monster_id=<?php if (isset($_GET["monster_id"])) echo $_GET["monster_id"]; ?>" method="post" novalidate>
    <section class="row">
      <h2>General Information</h2>
      <div class="col-sm-6 mb-2">
        <label class="form-label" for="name">Name</label>
        <input id="name" name="name" class="form-control" type="text" pattern="[\w\s]+" aria-required="true" required>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="size">Size</label>
        <select id="size" name="size" class="form-select" aria-required="true" required>
          <option selected disabled hidden>Select an option...</option>
          <?php foreach ($OPTIONS["size"] as $option) echo "<option>$option</option>\n"; ?>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="type">Type</label>
        <select id="type" name="type" class="form-select" aria-required="true" required>
          <option selected disabled hidden>Select an option...</option>
          <?php foreach ($OPTIONS["type"] as $option) echo "<option>$option</option>\n"; ?>
        </select>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="alignment">Alignment</label>
        <select id="alignment" name="alignment" class="form-select" aria-required="true" required>
          <option selected disabled hidden>Select an option...</option>
          <?php foreach ($OPTIONS["alignment"] as $option) echo "<option>$option</option>\n"; ?>
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
          <?php foreach ($OPTIONS["armor"] as $option) echo "<option data-ac=\"{$option["ac"]}\" data-type=\"{$option["type"]}\">{$option["name"]}</option>\n"; ?>
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
        <input id="armorClass" name="armor_class" class="form-control" type="number" min="0" max="30" aria-describedby="armorClassHelpLabel" aria-readonly="true" readonly>
        <div id="armorClassHelpLabel" class="form-text">
          Armor class updates automatically. For manual control, select <i>Natural Armor</i> or <i>Other</i>. <br>
        </div>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="hitDice">Hit Dice</label>
        <input id="hitDice" name="hit_dice" class="form-control" type="number" min="0" max="1000" aria-describedby="healthHelpLabel" aria-required="true" required>
        <div class="form-check mt-1">
          <input id="customHP" class="form-check-input" type="checkbox">
          <label class="form-check-label" for="customHP">
            Custom Health
          </label>
        </div>
      </div>

      <div class="col-sm-6 mb-2">
        <label class="form-label" for="health">Health Points (HP)</label>
        <input id="health" name="health" class="form-control" type="number" min="1" value="1" aria-describedby="healthHelpLabel" aria-readonly="true" readonly>
        <div id="healthHelpLabel" class="form-text">
          Health points are calculated automatically. For manual control, select <i>Custom Health</i>. <br>
        </div>
      </div>
    </section>
    <hr>

    <section>
      <h2>Movement</h2>
      <?php
      // MARK: MOVEMENT
      $TYPE = "speed";
      $CATEGORY = "speed";
      ?>

      <div id="<?php echo $CATEGORY; ?>Container"></div>
      <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
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
      </div>

      <?php
      // MARK: ABILITY SCORES
      foreach ($OPTIONS["ability_type"] as $CATEGORY) {
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
        // MARK: SKILL PROFICIENCIES
        $TYPE = "skill";
        $CATEGORY = "skillProficiency";
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>
        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Skill Expertises</h3>
        <?php
        // MARK: SKILL EXPERTISES
        $TYPE = "skill";
        $CATEGORY = "skillExpertise";
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>
        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Vulnerabilities</h3>
        <?php
        // MARK: DAMAGE VULNERABILITIES
        $TYPE = "damage_type";
        $CATEGORY = "damageVulnerability";
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>
        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Resistances</h3>
        <?php
        // MARK: DAMAGE RESISTANCES
        $TYPE = "damage_type";
        $CATEGORY = "damageResistance";
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>
        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Damage Immunities</h3>
        <?php
        // MARK: DAMAGE IMMUNITIES
        $TYPE = "damage_type";
        $CATEGORY = "damageImmunity";
        ?>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>
        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6 col-lg-4">
        <h3>Condition Immunities</h3>
        <?php
        // MARK: CONDITION IMMUNITIES
        $TYPE = "condition";
        $CATEGORY = "conditionImmunity";
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
        // MARK: SENSES
        $TYPE = "sense";
        $CATEGORY = "sense";
        ?>

        <div class="text-center mb-1">
          <input id="blind" name="blind" class="form-check-input" type="checkbox">
          <label class="form-check-label" for="blind">Blind</label>
        </div>

        <div id="<?php echo $CATEGORY; ?>Container" class="d-flex flex-column"></div>
        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
      </section>

      <section class="col-sm-6">
        <h3>Languages</h3>
        <?php
        // MARK: LANGUAGES
        $TYPE = "language";
        $CATEGORY = "language";
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
      // MARK: ABILITIES
      $TYPE = "ability";
      $CATEGORY = "ability";
      ?>

      <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>
      <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
    </section>
    <hr>

    <section>
      <h2>Actions</h2>
      <?php
      // MARK: ACTIONS
      $TYPE = "action";
      $CATEGORY = "action";
      ?>

      <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>
      <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
    </section>
    <hr>

    <section>
      <h2>Bonus Actions</h2>
      <?php
      // MARK: BONUS ACTIONS
      $TYPE = "bonus_action";
      $CATEGORY = "bonusAction";
      ?>

      <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>
      <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
    </section>
    <hr>

    <section>
      <h2>Reactions</h2>
      <?php
      // MARK: REACTIONS
      $TYPE = "reaction";
      $CATEGORY = "reaction";
      ?>

      <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>
      <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
    </section>
    <hr>

    <section>
      <h2>Legendary Features</h2>
      <?php
      // MARK: LEGENDARY FEATURES
      $TYPE = "legendary_feature";
      $CATEGORY = "legendaryFeature";
      ?>

      <div class="text-center mb-1">
        <input id="legendaryCheckbox" name="legendaryCheckbox" class="form-check-input" type="checkbox" style="border-width:1px; border-color:darkgray;">
        <label class="form-check-label" for="legendaryCheckbox"><strong>Legendary Monster</strong></label>
      </div>

      <div id="legendaryBlock" style="display:none">
        <div id="<?php echo $CATEGORY; ?>Container" class="row gx-sm-5 gy-sm-3"></div>
        <?php require '/opt/src/templates/monster-editor/attribute-modal.php'; ?>
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
            <?php
            foreach ($OPTIONS["challenge"] as $option) {
              if ($option["name"] === 0) {
                echo "<option value=\"{$option["value"]}\" selected>{$option["name"]}</option>\n";
              } else {
                echo "<option value=\"{$option["value"]}\">{$option["name"]}</option>\n";
              }
            }
            ?>
          </select>
        </div>
      </div>
    </section>

    <div class="d-flex justify-content-center mt-4">
      <a class="btn btn-secondary me-2" type="button" href="monster-api.php?command=view&monster_id=<?php if (isset($_GET["monster_id"])) echo $_GET["monster_id"]; ?>" target="_blank" style=" min-width:100px; font-size:x-large;">Export</a>
      <button id="saveButton" class="btn btn-success ms-2" type="submit" style="min-width:100px; font-size:x-large;">Save</button>
    </div>

    <input id="IDCounter" name="IDCounter" type="hidden" value="<?php echo $UNIQUE_ID; ?>">
  </form>

  <?php require '/opt/src/templates/footer.php'; ?>
  <?php require '/opt/src/templates/javascript.php'; ?>
</body>

</html>