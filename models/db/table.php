<?php

abstract class Table
{
    protected PDO $handle;

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

        $stmt = "INSERT INTO `{$this->name()}` ($keys) VALUES ($values);";
        $query = $this->handle->prepare($stmt);
        $query->execute($data);

        return $this->find($data);
    }

    public function replace(array $data)
    {
        $eq = array_map(fn($x) => "`$x` = :$x", array_keys($data));
        $eq = implode(", ", $eq);

        $id = $this->primary_key();
        $stmt = "UPDATE `{$this->name()}` SET $eq WHERE `$id` = :$id;";
        $query = $this->handle->prepare($stmt);
        $query->execute($data);

        return $this->find([$id => $data[$id]]);
    }

    public function delete(array $data): bool
    {
        $cond = implode(
            " AND ",
            array_map(fn($key) => "`$key` = :$key", array_keys($data))
        );

        $query = "DELETE FROM `{$this->name()}` WHERE $cond;";
        $stmt = $this->handle->prepare($query);
        $stmt->execute($data);

        return $stmt->rowCount() > 0;
    }

    public function filter(array $data): array|false
    {
        $cond = implode(
            " AND ",
            array_map(fn($key) => "`$key` = :$key", array_keys($data))
        );

        $query = "SELECT * FROM `{$this->name()}` WHERE $cond;";

        $stmt = $this->handle->prepare($query);
        $stmt->execute($data);

        return $stmt->fetchAll();
    }

    public function find(array $data): array|false
    {
        $cond = implode(
            " AND ",
            array_map(fn($key) => "`$key` = :$key", array_keys($data))
        );

        $query = "SELECT * FROM `{$this->name()}` WHERE $cond;";

        $stmt = $this->handle->prepare($query);
        $stmt->execute($data);

        return $stmt->fetch();
    }

    public function rows(): array
    {
        $query = $this->handle->prepare("SELECT * FROM `{$this->name()}`");
        $query->execute();

        return $query->fetchAll();
    }
}

?>