<?php
class EncounterGeneratorController extends BaseController
{
    private $difficulty_xp;
    private $monster_multiplier;
    private $input;

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
                require "{$GLOBALS['src']}/templates/encounter-generator/encounter-generator.php";
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
        $this->difficulty_xp = json_decode(file_get_contents("{$GLOBALS['src']}/templates/encounter-generator/difficulty-xp.json"), true);
    }

    public function loadMonsterMultiplier(): void
    {
        $this->monster_multiplier = json_decode(file_get_contents("{$GLOBALS['src']}/templates/encounter-generator/monster-multiplier.json"), true);
    }

    private function generate(): void
    {
        $encounter = [];
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
            if ($_POST["difficulty"] == "5") {
                if (isset($_POST["custom_xp"])) {
                    $difficulty = $_POST["custom_xp"];
                }
            } else {
                // (int)$_POST["difficulty"] - 1 to correctly index into the difficulty_xp array
                $difficulty = (int)$party_size * $this->difficulty_xp[$party_level][(int)$_POST["difficulty"] - 1];
            }
        }
        // types can be empty
        if (isset($_POST["types"])) {
            $types = $_POST["types"];
        }
        if (isset($_POST["min_cr"]) && !empty($_POST["min_cr"])) {
            switch ($_POST["min_cr"]) {
                case "1/8":
                    $min_cr = 1/8;
                    break;
                case "1/4":
                    $min_cr = 1/4;
                    break;
                case "1/2":
                    $min_cr = 1/2;
                    break;
                default:
                    $min_cr = (float)$_POST["min_cr"];
                    break;
            }
        }
        if (isset($_POST["max_cr"]) && !empty($_POST["max_cr"])) {
            switch ($_POST["max_cr"]) {
                case "1/8":
                    $max_cr = 1/8;
                    break;
                case "1/4":
                    $max_cr = 1/4;
                    break;
                case "1/2":
                    $max_cr = 1/2;
                    break;
                default:
                    $max_cr = (float)$_POST["max_cr"];
                    break;
            }
        }
        $added_monsters = [];
        if (isset($_POST["added_monsters"]) && !empty($_POST["added_monsters"])) {
            foreach($_POST["added_monsters"] as $monster) {
                $monster_name = explode(",", $monster)[0];
                $monster_id = explode(",", $monster)[1];
                $result = $this->database->query("select * from dnd_base_monsters where name = $1 and id = $2;", $monster_name, $monster_id);
                if (empty($result)) {
                    $result = $this->database->query("select * from dnd_monsters where name = $1 and id = $2", $monster_name, $monster_id);
                }
                if (!empty($result)) {
                    $added_monsters = array_merge($added_monsters, $result);
                }
            }
        }
        if ($min_cr > $max_cr) {
            $this->addMessage("danger","Error: the minimum CR cannot be greater than the maximum CR.");
        } else {
            $valid_monsters = [];
            // if types is empty, the monsters are only restricted by CR
            if (empty($types)) {
                $valid_monsters = $this->database->query("select * from dnd_base_monsters where cr >= $1 and cr <= $2;", $min_cr, $max_cr);
            } else {
                foreach ($types as $type) {
                    $result = $this->database->query("select * from dnd_base_monsters where cr >= $1 and cr <= $2 and type = $3;", $min_cr, $max_cr, $type);
                    $valid_monsters = array_merge($valid_monsters, $result);
                }
            }
            if (empty($valid_monsters)) {
                $this->addMessage("danger", "Error: no monsters meet the required specifications. Please broaden your search.");
            } else {
                $encounter = [];
                $encounter_xp = 0;
                $xp_modifier = 1;
                while ($xp_modifier * $encounter_xp < $difficulty) {
                    // add a random monster to the encounter
                    $rand_monster = $valid_monsters[array_rand($valid_monsters)];
                    $encounter[] = $rand_monster;
                    $encounter_xp += $rand_monster["xp"];
                    // get xp_modifier based on the number of monsters in the encounter
                    if (count($encounter) > 15) {
                        $xp_modifier = $this->monster_multiplier["15"];
                    } else {
                        $xp_modifier = $this->monster_multiplier[(string)count($encounter)];
                    }
                    // if adding the current monster make it so the encounter goes over the selected difficulty, such as from easy to medium, do not add that monster
                    // n/a if difficulty is already deadly or custom
                    if ($_POST["difficulty"] != "4" && $_POST["difficulty"] != "5") {
                        if ($xp_modifier * $encounter_xp > (int)$party_size * $this->difficulty_xp[$party_level][(int)$_POST["difficulty"]]) {
                            array_pop($encounter);
                        }
                    }
                }
                $encounter = array_merge($encounter, $added_monsters);
            }
        }
        require "{$GLOBALS['src']}/templates/encounter-generator/encounter-generator.php";
        $this->resetMessages();
    }
}
