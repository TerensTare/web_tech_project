<?php

session_start();

require_once __DIR__ . '/../utils/db.php';
require_once __DIR__ . '/../utils/defs.php';
require_once __DIR__ . '/../utils/session.php';

// actual logic
$__is_post = $_SERVER['REQUEST_METHOD'] == 'POST' or die('Only POST requests are allowed.');

$data = filter_login_data();

if (is_string($data)) {
    $_SESSION['message'] = '<div class="alert alert-danger" role="alert">' . $data . '!</div>';
    Session::redirect('/auth');
    exit;
}

session_regenerate_id(true);

$_SESSION['auth'] = true;
$_SESSION['id'] = $data[UsersTable::ID];

if ($data[UsersTable::ROLE] === UsersTable::ROLE_ADMIN) {
    $_SESSION['admin'] = true;
    Session::redirect('/admin');
} else {
    Session::redirect('/');
}

// helpers
function filter_login_data(): array|string
{
    $username = 'l-username';
    $password = 'l-password';

    if (!isset($_POST[$username]))
        return 'Missing username';
    if (!isset($_POST[$password]))
        return 'Missing password';

    $name = htmlspecialchars($_POST[$username]);
    $pwd = htmlspecialchars($_POST[$password]);

    $user = Db::self()->users()->find([UsersTable::USERNAME => $name]);

    if ($user === false)
        return "User doesn't exist";

    if (!password_verify($pwd, $user[UsersTable::PASSWORD]))
        return 'Incorrect username or password';

    return $user;
}
?>