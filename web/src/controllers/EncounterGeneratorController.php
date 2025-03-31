<?php
class EncounterGeneratorController extends BaseController
{
    private $difficulty_xp;
    private $monster_multiplier;

    public function __construct($input) {
        parent::__construct();
        $this->input = $input;
        $this->loadDifficultyXP();
        $this->loadMonsterMultiplier();
    }

    public function run(): void
    {
        $command = "initial";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch($command) {
            case "initial":
                $encounter = [];
                require "/opt/src/templates/encounter-generator/encounter-generator.php";
                $this->resetMessages();
                break;
            case "generate":
                $this->generate();
                break;
            default:
                break;
        }
    }

    public function loadDifficultyXP(): void
    {
        $this->difficulty_xp = json_decode(file_get_contents("/opt/src/templates/encounter-generator/difficulty-xp.JSON"), true);
    }

    public function loadMonsterMultiplier(): void
    {
        $this->monster_multiplier = json_decode(file_get_contents("/opt/src/templates/encounter-generator/monster-multiplier.JSON"), true);
    }

    private function generate(): void
    {
        $party_size = 0;
        $party_level = 1;
        $difficulty = 0;
        $types = [];
        $min_cr = 1/8;
        $max_cr = 30;
        if (isset($_POST["party_size"]) && !empty($_POST["party_size"])) {
            if ($_POST["party_size"] == "11") {
                if (isset($_POST["custom_party_size"]) && !empty($_POST["custom_party_size"])) {
                    $party_size = $_POST["custom_party_size"];
                }
            } else {
                $party_size = $_POST["party_size"];
            }
        }
        if (isset($_POST["party_level"]) && !empty($_POST["party_level"])) {
            $party_level = $_POST["party_level"];
        }
        if (isset($_POST["difficulty"]) && !empty($_POST["difficulty"])) {
            if ($_POST["difficulty"] == "4") {
                if (isset($_POST["custom_xp"])) {
                    $difficulty = $_POST["custom_xp"];
                }
            } else {
                $difficulty = (int)$party_size * $this->difficulty_xp[$party_level][(int)$_POST["difficulty"]];
            }
        }
        // types can be empty
        if (isset($_POST["types"])) {
            $types = $_POST["types"];
        }
        if (isset($_POST["min_cr"]) && !empty($_POST["min_cr"])) {
            $min_cr = (int)$_POST["min_cr"];
        }
        if (isset($_POST["max_cr"]) && !empty($_POST["max_cr"])) {
            $max_cr = (int)$_POST["max_cr"];
        }
        if ($min_cr > $max_cr) {
            $this->addMessage("danger","Error: the minimum CR cannot be greater than the maximum CR.");
        } else {
            $valid_monsters = [];
            // if types is empty, the monsters are only restricted by CR
            if (empty($types)) {
                // appending here instead of setting because valid_monsters uses appending if types isn't empty,
                // so the code that adds random monsters assumes that it is a 2d array
                $valid_monsters[] = $this->database->query("select * from dnd_base_monsters where cr >= $1 and cr <= $2;", $min_cr, $max_cr);
            } else {
                foreach ($types as $type) {
                    $result = $this->database->query("select * from dnd_base_monsters where cr >= $1 and cr <= $2 and type = $3;", $min_cr, $max_cr, $type);
                    $valid_monsters[] = $result;
                }
            }
            if (empty($valid_monsters)) {
                $this->addMessage("Error: no monsters meet the required specifications. Please broaden your search.");
            } else {
                $encounter = [];
                $encounter_xp = 0;
                $xp_modifier = 1;
                while ($xp_modifier * $encounter_xp < $difficulty) {
                    // add a random monster to the encounter
                    $rand_type = array_rand($valid_monsters);
                    $rand_monster = array_rand($valid_monsters[$rand_type]);
                    $monster = $valid_monsters[$rand_type][$rand_monster];
                    $encounter[] = $monster;
                    $encounter_xp += $monster["xp"];
                    // get xp_modifier based on the number of monsters in the encounter
                    if (count($encounter) > 15) {
                        $xp_modifier = $this->monster_multiplier["15"];
                    } else {
                        $xp_modifier = $this->monster_multiplier[(string)count($encounter)];
                    }
                    // if adding the current monster make it so the encounter goes over the selected difficulty, such as from easy to medium, do not add that monster
                    // TODO: check to see if it is impossible to add any monster without going up over difficulty
                    if ($_POST["difficulty"] != "3" && $_POST["difficulty"] != "4") {
                        if ($xp_modifier * $encounter_xp > (int)$party_size * $this->difficulty_xp[$party_level][(int)$_POST["difficulty"] + 1]) {
                            array_pop($encounter);
                        }
                    }
                }
            }
            require "/opt/src/templates/encounter-generator/encounter-generator.php";
            $this->resetMessages();
        }
    }
}
