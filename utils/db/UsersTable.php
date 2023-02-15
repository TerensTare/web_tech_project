<?php


class UsersTable
{
    private PDO $handle;

    public function __construct(PDO $handle)
    {
        $this->handle = $handle;
    }

    public function get(int $id)
    {
        $stmt = $this->handle->prepare('SELECT * FROM `gamehub`.`users` WHERE `id` = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function exists(string $name)
    {
        $stmt = $this->handle->prepare('SELECT * FROM `gamehub`.`users` WHERE `username` = :name');
        $stmt->execute(['name' => $name]);
        return $stmt->rowCount() > 0;
    }

    public function insert(string $name, string $pwd, string $email)
    {
        $stmt = $this->handle->prepare('INSERT INTO `gamehub`.`users` (username, pwd, email, `role`) VALUES (:uname, :pwd, :email, \'user\')');
        return $stmt->execute(['uname' => $name, 'pwd' => $pwd, 'email' => $email]);
    }
}

?>