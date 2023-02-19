<?php

if (!isset($_SESSION) || !isset($_SESSION['admin'])) {
    header('Location: /404');
}

require_once __DIR__ . '/../utils/db.php';
require_once __DIR__ . '/../utils/defs.php';
require_once __DIR__ . '/../utils/session.php';

function user_table(): string
{
    $users = Db::self()->users()->filter([UsersTable::ROLE => UsersTable::ROLE_USER]);

    $html = <<<HTML
<h2>Users</h2>
<table class="table table-bordered">
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
HTML;

    if ($users !== false) {
        foreach ($users as $user) {
            $html .= <<<HTML
    <tr class="user-data">
        <td>{$user[UsersTable::USERNAME]}</td>
        <td>{$user[UsersTable::EMAIL]}</td>
        <td>
            <a href="/views/user_panel.php/?action=edit&id={$user[UsersTable::ID]}" title="Edit"><i class="fas fa-edit"></i></a>
            <a href="/views/user_panel.php/?action=delete&id={$user[UsersTable::ID]}" title="Delete"><i class="fas fa-trash text-danger"></i></a>
            <a href="/views/user_panel.php/?action=reset&id={$user[UsersTable::ID]}" title="Reset password"><i class="fas fa-key text-warning"></i></a>
        </td>
    </tr>
HTML;
        }
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
        <th>Actions</th>
    </tr>
HTML;

    foreach ($games as $game) {
        $html .= <<<HTML
    <tr class="game-data">
        <td>{$game[GamesTable::NAME]}</td>
        <td>
            <a href="/admin/user/?action=edit&id={$game[GamesTable::ID]}" title="Rename"><i class="fas fa-edit"></i></a>
            <a href="/admin/user/?action=delete&id={$game[GamesTable::ID]}" title="Delete"><i class="fas fa-trash text-danger"></i></a>
        </td>
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
    <?php
    require_once __DIR__ . '/navbar.php';

    echo Navbar::build();
    echo user_table();
    echo games_table();
    ?>
</body>

</html>