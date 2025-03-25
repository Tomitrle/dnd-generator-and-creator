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
        $this->createTables();
    }

    public function dropTables() : void
    {
        // MARK: TODO
        // pg_query($this->connection, "DROP TABLE IF EXISTS ... CASCADE;");
    }

    public function createTables() : void
    {
        // MARK: TODO
//         $result = pg_query($this->connection, "CREATE TABLE IF NOT EXISTS hw6_users (
//             id          SERIAL PRIMARY KEY,
//             name        TEXT,
//             email       TEXT,
//             password    TEXT
//             );");
//
//         $result = pg_query($this->connection, "CREATE TABLE IF NOT EXISTS ... (
//             id          SERIAL PRIMARY KEY,
//             userID      INT REFERENCES hw6_users(id) ON DELETE CASCADE ON UPDATE CASCADE,
//             word        TEXT,
//             victory     BOOLEAN,
//             score       INT
//             );");
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
