<div class="card">
    <div class="card-body">
        <h5 class="card-title">Generated Encounter</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    </div>
    <ul class="list-group list-group-flush">
        <?php
        foreach ($encounter as $encounter_monster) {
            echo '<li class="list-group-item">' . $encounter_monster["name"] . '</li>';
        }
        ?>
    </ul>
</div>