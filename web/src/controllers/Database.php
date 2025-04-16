<?php
class Database
{
    private $connection;

    public function __construct()
    {
        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["pass"];
        $port = Config::$db["port"];

        $this->connection = pg_connect("host=$host port=$port dbname=$database user=$user password=$password") or die("Could not connect to the database.");
    }

    public function dropTables() : void
    {
        pg_query($this->connection, "DROP TABLE IF EXISTS dnd_users CASCADE;");
        pg_query($this->connection, "DROP TABLE IF EXISTS dnd_monsters CASCADE;");
        pg_query($this->connection, "DROP TABLE IF EXISTS dnd_attributes CASCADE;");
        pg_query($this->connection, "DROP TABLE IF EXISTS dnd_base_monsters CASCADE;");
    }

    public function createTables() : void
    {
        pg_query($this->connection, "CREATE TABLE IF NOT EXISTS dnd_users (
            id              SERIAL PRIMARY KEY,
            username        TEXT,
            password        TEXT
            );");

        pg_query($this->connection, "CREATE TABLE IF NOT EXISTS dnd_monsters (
            id              SERIAL PRIMARY KEY,
            user_id          INT REFERENCES dnd_users(id) ON DELETE CASCADE,
            name            TEXT,
            size            TEXT,
            type            TEXT,
            alignment       TEXT,
            armor           TEXT,
            shield          BOOLEAN,
            armor_class      INT,
            hit_dice         INT,
            health          INT,

            strength_score        INT,
            dexterity_score       INT,
            constitution_score    INT,
            intelligence_score    INT,
            wisdom_score          INT,
            charisma_score       INT,

            strength_modifier        INT,
            dexterity_modifier       INT,
            constitution_modifier    INT,
            intelligence_modifier    INT,
            wisdom_modifier          INT,
            charisma_modifier       INT,

            strength_saving_throw        BOOLEAN,
            dexterity_saving_throw       BOOLEAN,
            constitution_saving_throw    BOOLEAN,
            intelligence_saving_throw    BOOLEAN,
            wisdom_saving_throw          BOOLEAN,
            charisma_saving_throw       BOOLEAN,

            blind           BOOLEAN,
            telepathy       INT,
            challenge       TEXT
            );");

        pg_query($this->connection, "CREATE TABLE IF NOT EXISTS dnd_attributes (
            id              SERIAL PRIMARY KEY,
            monster_id       INT REFERENCES dnd_monsters(id) ON DELETE CASCADE,
            type            TEXT,
            name            TEXT,
            range           INT,
            description     TEXT,
            benefit         INT
            );");

        pg_query($this->connection, "CREATE TABLE IF NOT EXISTS dnd_base_monsters (
            id              SERIAL PRIMARY KEY,
            name            TEXT,
            size            TEXT,
            type            TEXT,
            alignment       TEXT,
            armor           TEXT,
            shield          BOOLEAN,
            armor_class      INT,
            hit_dice         INT,
            health          INT,
            cr              FLOAT,
            xp              INT,

            strength_score        INT,
            dexterity_score       INT,
            constitution_score    INT,
            intelligence_score    INT,
            wisdom_score          INT,
            charisma_score       INT,

            strength_modifier        INT,
            dexterity_modifier       INT,
            constitution_modifier    INT,
            intelligence_modifier    INT,
            wisdom_modifier          INT,
            charisma_modifier       INT,

            strength_saving_throw        BOOLEAN,
            dexterity_saving_throw       BOOLEAN,
            constitution_saving_throw    BOOLEAN,
            intelligence_saving_throw    BOOLEAN,
            wisdom_saving_throw          BOOLEAN,
            charisma_saving_throw       BOOLEAN,

            blind           BOOLEAN,
            telepathy       INT,
            challenge       TEXT
            );");
    }

    public function query($query, ...$params) : bool | array
    {
        $result = pg_query_params($this->connection, $query, $params);

        if ($result === false) {
            echo pg_last_error($this->connection);
            return false;
        }

        return pg_fetch_all($result);
    }
}
