<?php
class EncounterGeneratorController
{
    private $db;
    private $difficulty_xp;
    private $monster_multiplier;

    public function __construct($input) {
        session_start();
        $this->db = new Database();
        $this->input = $input;
        $this->loadDifficultyXP();
        $this->loadMonsterMultiplier();
    }

    public function run(): void
    {
        $command = "";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch($command) {
            case "generate":
                $this->generate();
                break;
            default:
                break;
        }
    }

    public function loadDifficultyXP() {
        $this->difficulty_xp = json_decode(file_get_contents("/opt/src/encounter-generator/difficulty_xp.JSON"), true);
    }

    public function loadMonsterMultiplier() {
        $this->monster_multiplier = json_decode(file_get_contents("/opt/src/encounter-generator/monster_multiplier.JSON"), true);
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
            $_SESSION["party_size"] = $party_size;
        }
        if (isset($_POST["party_level"]) && !empty($_POST["party_level"])) {
            $party_level = $_POST["party_level"];
            $_SESSION["party_level"] = $party_level;
        }
        if (isset($_POST["difficulty"]) && !empty($_POST["difficulty"])) {
            if ($_POST["difficulty"] == "4") {
                if (isset($_POST["custom_xp"])) {
                    $difficulty = $_POST["custom_xp"];
                }
            } else {
                $difficulty = (int)$party_size * $this->difficulty_xp[$party_level][(int)$_POST["difficulty"]];
            }
            $_SESSION["difficulty"] = $difficulty;
        }
        if (isset($_POST["types"]) && !empty($_POST["types"])) {
            $types = $_POST["types"];
            $_SESSION["types"] = $types;
        }
        if (isset($_POST["min_cr"]) && !empty($_POST["min_cr"])) {
            $min_cr = $_POST["min_cr"];
            $_SESSION["min_cr"] = $min_cr;
        }
        if (isset($_POST["max_cr"]) && !empty($_POST["max_cr"])) {
            $max_cr = $_POST["max_cr"];
            $_SESSION["max_cr"] = $max_cr;
        }
    }
}
