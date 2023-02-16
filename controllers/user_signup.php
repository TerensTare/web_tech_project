<?php

session_start();

require_once __DIR__ . '/../utils/db.php';
require_once __DIR__ . '/../utils/defs.php';
require_once __DIR__ . '/../utils/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clean = [];
    if (isset($_POST['l-username'])) {
        $clean['username'] = htmlspecialchars($_POST['l-username']);
    }

    if (isset($_POST['l-password'])) {
        $clean['password'] = htmlspecialchars($_POST['l-password']);
    }

    $hashed_pwd = password_hash($clean['password'], PASSWORD_DEFAULT);
    $stmt = Db::self()->users()->insert([
        UsersTable::USERNAME => $clean['username'],
        UsersTable::PASSWORD => $hashed_pwd,
        UsersTable::EMAIL => $clean['email'],
        UsersTable::ROLE => UsersTable::ROLE_USER
    ]);

    Session::redirect("/");
} else {
    die('Only POST requests are allowed.');
}

?>