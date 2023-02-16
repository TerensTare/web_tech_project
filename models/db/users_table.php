<?php

require_once 'models/db/table.php';

class UsersTable extends Table
{
    public const ID = "id";
    public const USERNAME = "username";
    public const PASSWORD = "password";
    public const EMAIL = "email";

    public function __construct(PDO $handle)
    {
        parent::__construct($handle);
    }

    public function name(): string
    {
        return "users";
    }

    public function columns(): array
    {
        return [self::ID, self::USERNAME, self::PASSWORD, self::EMAIL];
    }

    public function primary_key(): string
    {
        return "id";
    }
}

?>