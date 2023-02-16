<?php

session_start();

require_once __DIR__ . '/../utils/db.php';
require_once __DIR__ . '/../utils/defs.php';
require_once __DIR__ . '/../utils/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['l-username']) || !isset($_POST['l-password'])) {
        die('Invalid request.');
    }

    $name = htmlspecialchars($_POST[UsersTable::USERNAME]);
    $pwd = htmlspecialchars($_POST[UsersTable::PASSWORD]);

    $user = Db::self()->users()->find([UsersTable::USERNAME => $name]);

    if ($user === false) {
        Session::flash('login', 'Invalid username');
        Session::redirect('/auth');
        die();
    }

    if (!password_verify($pwd, $user[UsersTable::PASSWORD])) {
        Session::flash('login', 'Invalid password');
        Session::redirect('/auth');
        die();
    }

    session_regenerate_id();
    $_SESSION['auth'] = true;
    $_SESSION['user'] = $user[UsersTable::USERNAME];
    $_SESSION['id'] = $user[UsersTable::ID];
    $_SESSION['role'] = $user[UsersTable::ROLE];

    if ($user[UsersTable::ROLE] == UsersTable::ROLE_ADMIN) {
        Session::redirect('/admin');
    } else {
        Session::redirect('/');
    }

    die();

} else {
    die('Only POST requests are allowed.');
}

?>