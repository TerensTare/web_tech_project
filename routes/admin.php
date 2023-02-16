<?php

require_once __DIR__ . '/../utils/route.php';
require_once __DIR__ . '/../utils/session.php';

class AdminRoute extends Route
{
    public function enter()
    {
        if (!isset($_SESSION['user'])) {
            Session::flash('login', 'You must be logged in to access this page');
            Session::redirect('/auth');
            return;
        }

        $user = Db::self()->users()->find([UsersTable::ID => $_SESSION['user']]);
        if ($user[UsersTable::ROLE] != 'a') {
            Session::flash('login', 'You must be an admin to access this page');
            Session::redirect('/auth');
            return;
        }

        require_once __DIR__ . '/../views/admin.php';
    }
}

?>