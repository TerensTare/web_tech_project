<?php

require_once __DIR__ . '/../utils/db.php';
require_once __DIR__ . '/../utils/defs.php';
require_once __DIR__ . '/../utils/session.php';

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    Session::redirect('/');
    die();
}

if ($_SESSION['role'] != UsersTable::ROLE_ADMIN) {
    Session::redirect('/');
    die();
}

function user_table(): string
{
    $users = Db::self()->users()->rows();

    $html = <<<HTML
<h2>Users</h2>
<table class="table table-bordered">
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
    </tr>
HTML;


    foreach ($users as $user) {
        $html .= <<<HTML
    <tr>
        <td>{$user[UsersTable::USERNAME]}</td>
        <td>{$user[UsersTable::EMAIL]}</td>
        <td>{$user[UsersTable::ROLE]}</td>
    </tr>
HTML;
    }

    $html .= "</table>";

    return $html;
}

function games_table(): string
{
    $games = Db::self()->games()->rows();

    $html = <<<HTML
<h2>Games</h2>
<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Folder</th>
    </tr>
HTML;

    foreach ($games as $game) {
        $html .= <<<HTML
    <tr>
        <td>{$game[GamesTable::NAME]}</td>
        <td>{$game[GamesTable::FOLDER]}</td>
    </tr>
HTML;
    }

    $html .= "</table>";

    return $html;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <title>GameHub Dashboard</title>
</head>

<body>
    <?= user_table() ?>
    <?= games_table() ?>
</body>

</html>