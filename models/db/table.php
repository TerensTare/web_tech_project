<?php

abstract class Table
{
    private PDO $handle;

    protected function __construct(PDO $handle)
    {
        $this->handle = $handle;
    }

    // customization points
    public abstract function name(): string;

    public abstract function columns(): array;

    public abstract function primary_key(): string;

    // helper functions
    public function insert(array $data)
    {
        $keys = array_map(fn($x) => "`$x`", array_keys($data));
        $keys = implode(", ", $keys);

        $values = array_map(fn($x) => ":$x", array_keys($data));
        $values = implode(", ", $values);

        $stmt = "INSERT INTO `{$this->name()}` ($keys) VALUES ($values)";
        $query = $this->handle->prepare($stmt);

        $query->execute($data);
        $result = $query->fetch();
        $query->closeCursor();

        return $result;
    }

    public function find(array $data): array|false
    {
        $cond = implode(
            " AND ",
            array_map(fn($key) => "$key = :$key", array_keys($data))
        );

        $query = "SELECT * FROM `{$this->name()}` WHERE $cond;";

        $stmt = $this->handle->prepare($query);
        $stmt->execute($data);

        $result = $stmt->fetch();
        $stmt->closeCursor();

        return $result;
    }

    public function rows(): array
    {
        $stmt = "SELECT * FROM `{$this->name()}`";
        $query = $this->handle->prepare($stmt);
        $query->execute();

        $result = $query->fetchAll();
        $query->closeCursor();

        return $result;
    }
}

?>