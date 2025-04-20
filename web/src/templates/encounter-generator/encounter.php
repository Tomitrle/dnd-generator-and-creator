<div class="container">
    <?php
    if (!empty($encounter)) {
        echo '<h1>Your Encounter</h1>';
    }
    foreach ($encounter as $encounter_monster) {
        switch ($encounter_monster["cr"]) {
            case 1/8:
                echo '<h2>' . $encounter_monster["name"] . ', CR 1/8 ' . $encounter_monster["type"] . ', ' . $encounter_monster["xp"] . ' XP' . '</h2><br>';
                break;
            case 1/4:
                echo '<h2>' . $encounter_monster["name"] . ', CR 1/4 ' . $encounter_monster["type"] . ', ' . $encounter_monster["xp"] . ' XP' . '</h2><br>';
                break;
            case 1/2:
                echo '<h2>' . $encounter_monster["name"] . ', CR 1/2 ' . $encounter_monster["type"] . ', ' . $encounter_monster["xp"] . ' XP' . '</h2><br>';
                break;
            default:
                echo '<h2>' . $encounter_monster["name"] . ', CR ' . $encounter_monster["cr"] . ' ' . $encounter_monster["type"] . ', ' . $encounter_monster["xp"] . ' XP' . '</h2><br>';
                break;
        }
    }
    ?>
</div>