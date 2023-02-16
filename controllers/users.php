<?php

require_once '../utils/db.php';
require_once '../utils/defs.php';
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
        return array_map(fn($x) => htmlspecialchars($data[$x]), $udata);
    }

    public function signup(array $data)
    {
        $data = $this->sanitize($data);
        $name = $data[UsersTable::USERNAME];
        $email = $data[UsersTable::EMAIL];
        $pwd = $data[UsersTable::PASSWORD];

        if (!preg_match('/' . USERNAME_REGEX . '/', $name)) {
            Session::flash('signup', 'Invalid username');
            Session::redirect('/auth');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('signup', 'Invalid email');
            Session::redirect('/auth');
        }

        if (!preg_match('/' . PASSWORD_REGEX . '/', $pwd)) {
            Session::flash('signup', 'Invalid password');
            Session::redirect('/auth');
        }

        $pwd = password_hash($pwd, PASSWORD_DEFAULT);

        $ut = Db::self()->users();
        if ($ut->find([UsersTable::USERNAME => $name]) !== false) {
            Session::flash('signup', 'Username already exists');
            Session::redirect('/auth');
        }

        $user = $ut->insert([
            UsersTable::USERNAME => $name,
            UsersTable::EMAIL => $email,
            UsersTable::PASSWORD => $pwd,
        ]);

        session_start();
        session_regenerate_id();

        $_SESSION['user'] = $user[UsersTable::ID];

        if ($user[UsersTable::ROLE] == 'a')
            Session::redirect('/admin');
        else
            Session::redirect('/');
    }

    public function login(array $data)
    {
        $data = $this->sanitize($data);
        $name = $data[UsersTable::USERNAME];
        $pwd = $data[UsersTable::PASSWORD];

        $ut = Db::self()->users();
        $user = $ut->find([UsersTable::USERNAME => $name]);

        if ($user === false) {
            Session::flash('login', 'Invalid username');
            Session::redirect('/auth');
        }

        if (!password_verify($pwd, $user[UsersTable::PASSWORD])) {
            Session::flash('login', 'Invalid password');
            Session::redirect('/auth');
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
            Users::self()->signup($_POST);
            break;

        case 'login':
            Users::self()->login($_POST);
            break;
    }
}

?>