<?php

require_once __DIR__ . '/../models/db/game_tags_rel_table.php';
require_once __DIR__ . '/../models/db/games_table.php';
require_once __DIR__ . '/../models/db/tags_table.php';
require_once __DIR__ . '/../models/db/users_table.php';

class Db
{
    private const host = 'localhost';
    private const name = 'game_hub';
    private const user = 'root';
    private const pwd = '18273645';

    private PDO $handle;
    private UsersTable $users;
    private GamesTable $games;
    private TagsTable $tags;
    private GameTagsTable $game_tags_rel;

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

    public function tags()
    {
        return $this->tags;
    }

    public function game_tags_rel()
    {
        return $this->game_tags_rel;
    }

    private function __construct()
    {
        try {
            $this->handle = new PDO(
                "mysql:host=" . DB::host . ";dbname=" . DB::name . ";charset=utf8mb4",
                    DB::user, DB::pwd,
                [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            echo <<<HTML
            <h2 class='text-center'>Couldn't connect with the database.</h2>
            <p class='text-center'>Please try again later.</p>
            <div class='text-center'>
                <button class='btn btn-primary' onclick='window.location.reload()'>Reload</button>
            </div>
            HTML;
        }

        $query = file_get_contents(__DIR__ . "/../game_hub.sql");
        $stmt = $this->handle->prepare($query);
        $stmt->execute();
        $stmt->closeCursor(); // we need to wait for the query to finish before we can execute the next one

        $this->users = new UsersTable($this->handle);
        $this->games = new GamesTable($this->handle);
        $this->tags = new TagsTable($this->handle);
        $this->game_tags_rel = new GameTagsTable($this->handle);

        if (file_exists(__DIR__ . "/../.admin"))
            return;

        $this->users->insert([
            UsersTable::USERNAME => "admin",
            UsersTable::PASSWORD => password_hash("Adminn1234", PASSWORD_DEFAULT),
            UsersTable::EMAIL => "admin@localhost",
            UsersTable::ROLE => UsersTable::ROLE_ADMIN
        ]);
        // create a file to indicate that the admin account has been created
        fopen(__DIR__ . "/../.admin", "w");
    }
}

?>