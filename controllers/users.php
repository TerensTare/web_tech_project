<?php

require_once '../utils/db.php';
require_once '../utils/session.php';

class Users
{
    public static function self()
    {
        static $inst = new Users();
        return $inst;
    }

    private function sanitize(array $udata): array
    {
        return array_map(fn($x) => htmlspecialchars($x), $udata);
    }

    public function signup($name, $email, $pwd)
    {
        [$name, $email, $pwd] = $this->sanitize([$name, $email, $pwd]);

        if (!preg_match('/' . USERNAME_REGEX . '/', $name)) {
            Session::flash('signup', 'Invalid username');
            Session::redirect('./signup.php');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('signup', 'Invalid email');
            Session::redirect('./signup.php');
        }

        if (!preg_match('/' . PASSWORD_REGEX . '/', $pwd)) {
            Session::flash('signup', 'Invalid password');
            Session::redirect('./signup.php');
        }

        $pwd = password_hash($pwd, PASSWORD_DEFAULT);

        $ut = Db::self()->users();
        if ($ut->find([UsersTable::USERNAME => $name]) !== false) {
            Session::flash('signup', 'Username already exists');
            Session::redirect('./signup.php');
        }

        $user = $ut->insert([
            UsersTable::USERNAME => $name,
            UsersTable::EMAIL => $email,
            UsersTable::PASSWORD => $pwd,
        ]);

        session_start();
        session_regenerate_id();

        $_SESSION['user'] = $user[UsersTable::ID];

        Session::redirect('/');
    }

    public function login($name, $pwd)
    {
        [$name, $pwd] = $this->sanitize([$name, $pwd]);

        $ut = Db::self()->users();
        $user = $ut->find([UsersTable::USERNAME => $name]);

        if ($user === false) {
            Session::flash('login', 'Invalid username');
            Session::redirect('/login');
        }

        if (!password_verify($pwd, $user[UsersTable::PASSWORD])) {
            Session::flash('login', 'Invalid password');
            Session::redirect('/login');
        }

        session_start();
        session_regenerate_id();

        $_SESSION['user'] = $user[UsersTable::ID];

        Session::redirect('/');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['kind']) {
        case 'signup':
            Users::self()->signup($_POST['user'], $_POST['email'], $_POST['password']);
            break;

        case 'login':
            Users::self()->login($_POST['user'], $_POST['password']);
            break;
    }
}

?>