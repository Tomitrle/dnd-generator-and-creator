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
            userID          INT REFERENCES dnd_users(id) ON DELETE CASCADE,
            name            TEXT,
            size            TEXT,
            type            TEXT,
            alignment       TEXT,
            armor           TEXT,
            shield          BOOLEAN,
            armorClass      INT,
            hitDice         INT,
            health          INT,
            speedRange      INT,
            strength        INT,
            dexterity       INT,
            constitution    INT,
            intelligence    INT,
            wisdom          INT,
            charmisma       INT,
            strengthSavingThrow        BOOLEAN,
            dexteritySavingThrow       BOOLEAN,
            constitutionSavingThrow    BOOLEAN,
            intelligenceSavingThrow    BOOLEAN,
            wisdomSavingThrow          BOOLEAN,
            charmismaSavingThrow       BOOLEAN,
            blind           BOOLEAN,
            telepathy       INT,
            challenge       TEXT
            );");

        pg_query($this->connection, "CREATE TABLE IF NOT EXISTS dnd_attributes (
            id              SERIAL PRIMARY KEY,
            monsterID       INT REFERENCES dnd_monsters(id) ON DELETE CASCADE,
            type            TEXT,
            name            TEXT,
            range           INT,
            description     TEXT,
            benefit         INT
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
