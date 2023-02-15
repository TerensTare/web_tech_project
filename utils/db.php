<?php

require_once './db/UsersTable.php';

class Db
{
    private const host = 'localhost';
    private const name = 'gamehub';
    private const user = 'root';
    private const pwd = '';

    private PDO $handle;
    private UsersTable $users;

    public static function self()
    {
        static $inst = new Db();
        return $inst;
    }

    public function users()
    {
        return $this->users;
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

        $this->users = new UsersTable($this->handle);
    }
}

?>