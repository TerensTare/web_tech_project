<?php

require_once '../models/db/games_table.php';
require_once '../models/db/users_table.php';

class Db
{
    private const host = 'localhost';
    private const name = 'game_hub';
    private const user = 'root';
    private const pwd = '18273645';

    private PDO $handle;
    private UsersTable $users;
    private GamesTable $games;

    public static function self()
    {
        static $inst = new Db();
        return $inst;
    }

    public function users()
    {
        return $this->users;
    }

    public function games()
    {
        return $this->games;
    }

    private function __construct()
    {
        $this->handle = new PDO(
            "mysql:host=" . DB::host . ";dbname=" . DB::name . ";charset=utf8mb4",
                DB::user, DB::pwd,
            [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

        $query = file_get_contents("../game_hub.sql");
        $stmt = $this->handle->prepare($query);
        $stmt->execute();

        $this->users = new UsersTable($this->handle);
        $this->games = new GamesTable($this->handle);
    }
}

?>