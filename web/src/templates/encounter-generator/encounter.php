<?php
if (!empty($encounter)) {
    echo '<div class="card">
            <div class="card-body">
                <h5 class="card-title">Generated Encounter</h5>
            </div>
            <ul class="list-group list-group-flush">';
    foreach ($encounter as $encounter_monster) {
        echo '<li class="list-group-item">' . $encounter_monster["name"] . '</li>';
    }
    echo '</ul>
    </div>';
}
?>