<?php

require_once '../models/db/table.php';

class GamesTable extends Table
{
    public const ID = "id";
    public const NAME = "name";
    public const FOLDER = "folder";

    public function __construct(PDO $handle)
    {
        parent::__construct($handle);
    }

    public function name(): string
    {
        return "games";
    }

    public function columns(): array
    {
        return [self::ID, self::NAME, self::FOLDER];
    }

    public function primary_key(): string
    {
        return "id";
    }
}