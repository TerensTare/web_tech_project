<?php

session_start();

require_once __DIR__ . '/../utils/db.php';
require_once __DIR__ . '/../utils/defs.php';
require_once __DIR__ . '/../utils/session.php';

// actual logic

$__is_post = $_SERVER['REQUEST_METHOD'] == 'POST' or die('Only POST requests are allowed.');

$data = filter_signup_data();

if (is_string($data)) {
    $_SESSION['message'] = '<div class="alert alert-danger" role="alert">' . $data . '!</div>';
    Session::redirect('/auth');
    exit;
}

$stmt = Db::self()->users()->insert($data);

$_SESSION['message'] = <<<HTML
<div class="alert alert-success">Account created successfully.</div>
HTML;

Session::redirect('/auth');

// helpers
function filter_signup_data()
{
    $clean = [];

    $username = 's-username';
    $password = 's-password';
    $email = 'email';

    if (!isset($_POST[$username]))
        return 'Missing username';
    if (!isset($_POST[$password]))
        return 'Missing password';
    if (!isset($_POST[$email]))
        return 'Missing email';

    if (preg_match(USERNAME_REGEX, $_POST[$username])) {
        $clean[UsersTable::USERNAME] = htmlspecialchars($_POST[$username]);
    } else {
        return 'Invalid username';
    }

    if (preg_match(PASSWORD_REGEX, $_POST[$password])) {
        $clean[UsersTable::PASSWORD] = htmlspecialchars($_POST[$password]);
    } else {
        return 'Invalid password';
    }

    $clean[UsersTable::PASSWORD] = password_hash($clean[UsersTable::PASSWORD], PASSWORD_DEFAULT);

    if (isset($_POST[$email]) && filter_var($_POST[$email], FILTER_VALIDATE_EMAIL)) {
        $clean[UsersTable::EMAIL] = htmlspecialchars($_POST[$email]);
    } else {
        return 'Invalid email';
    }

    $clean[UsersTable::ROLE] = UsersTable::ROLE_USER;

    $existing = Db::self()->users()->find([UsersTable::USERNAME => $clean[UsersTable::USERNAME]]);
    if ($existing !== false)
        return 'Username already exists';

    return $clean;
}
?>