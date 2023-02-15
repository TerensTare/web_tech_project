<?php

require_once 'utils/db.php';
require_once 'utils/session.php';

class Users
{
    public static function self()
    {
        static $inst = new Users();
        return $inst;
    }

    public function signup($name, $email, $pwd)
    {
        $name = htmlspecialchars($name);
        $pwd = htmlspecialchars($pwd);
        $email = htmlspecialchars($email);

        if (!preg_match(USERNAME_REGEX, $name)) {
            Session::flash('signup', 'Invalid username');
            Session::redirect('./signup.php');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('signup', 'Invalid email');
            Session::redirect('./signup.php');
        }

        if (!preg_match(PASSWORD_REGEX, $pwd)) {
            Session::flash('signup', 'Invalid password');
            Session::redirect('./signup.php');
        }

        $pwd = password_hash($pwd, PASSWORD_DEFAULT);

        $ut = Db::self()->users();
        if ($ut->exists($name)) {
            Session::flash('signup', 'Username already exists');
            Session::redirect('./signup.php');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['kind']) {
        case 'signup':
            Users::self()->signup($_POST['user'], $_POST['email'], $_POST['password']);
            break;
    }
}

?>