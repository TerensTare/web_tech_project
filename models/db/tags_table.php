<?php

require_once __DIR__ . '/table.php';

class TagsTable extends Table
{
    public const ID = "id";
    public const NAME = "name";

    public function __construct(PDO $handle)
    {
        parent::__construct($handle);
    }

    public function name(): string
    {
        return "tags";
    }

    public function columns(): array
    {
        return [self::ID, self::NAME];
    }

    public function primary_key(): string
    {
        return self::ID;
    }
}