<?php

if (!isset($_SESSION) || !isset($_SESSION['admin'])) {
    header('Location: /404');
}

require_once __DIR__ . '/../utils/db.php';
require_once __DIR__ . '/../utils/session.php';



if (isset($_GET['action']) && isset($_GET['id'])) {
    switch ($_GET['action']) {
        case 'edit':
            echo edit($_GET['id']);
            break;

        case 'delete':
            remove($_GET['id']);
            break;

        case 'reset':
            reset_pwd($_GET['id']);
            break;

        default:
            Session::redirect('/404');
            break;
    }
} else {
    Session::redirect('/404');
}

function edit($id)
{
    $user = Db::self()->users()->find([UsersTable::ID => $id]);

    if ($user === false) {
        return <<<HTML
<div class="alert alert-danger">
    <strong>Error!</strong> User not found.
</div>
HTML;
    }

    $html = <<<HTML
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit user</h3>
        <div class="card-tools">
            <a href="/admin/user/" class="btn btn-tool">
                <i class="fas fa-times"></i>
            </a>
            <a href="/admin/user/?action=delete&id={$user[UsersTable::ID]}" class="btn btn-tool">
                <i class="fas fa-trash text-danger"></i>
                <span class="text-danger">Delete</span>
            </a>
</div>
</div>
</div>
HTML;
}

function remove($id)
{
    $user = Db::self()->users()->find([UsersTable::ID => $id]);

    if ($user === false) {
        Session::redirect('/404');
    } else {
        Db::self()->users()->delete([UsersTable::ID => $id]);
        Session::redirect('/admin');
    }
}

function reset_pwd($id)
{
    $user = Db::self()->users()->find([UsersTable::ID => $id]);

    if ($user === false) {
        Session::redirect('/404');
    } else {
        $password = "User" . $id . "Password";
        $hash = password_hash($password, PASSWORD_DEFAULT);

        Db::self()->users()->replace([
            UsersTable::ID => $id,
            UsersTable::PASSWORD => $hash,
        ]);

        Session::redirect('/admin');
    }
}

?>