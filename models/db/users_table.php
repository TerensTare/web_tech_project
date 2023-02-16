<?php

require_once __DIR__ . '/table.php';

class UsersTable extends Table
{
    public const ID = "id";
    public const USERNAME = "username";
    public const PASSWORD = "password";
    public const EMAIL = "email";
    public const ROLE = "role";

    public const ROLE_USER = "u";
    public const ROLE_ADMIN = "a";

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
        return [self::ID, self::USERNAME, self::PASSWORD, self::EMAIL, self::ROLE];
    }

    public function primary_key(): string
    {
        return "id";
    }
}

?>