<div class="container">
    <?php
    if (!empty($encounter)) {
        echo '<h1>Your Encounter</h1>';
    }
    foreach ($encounter as $encounter_monster) {
        echo '<h2>' . $encounter_monster["name"] . ', CR ' . $encounter_monster["cr"] . ' ' . $encounter_monster["type"] . ', ' . $encounter_monster["xp"] . ' XP' . '</h2><br>';
    }
    ?>
</div>