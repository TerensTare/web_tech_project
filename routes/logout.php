<?php


require_once __DIR__ . '/../utils/route.php';

class LogoutRoute extends Route
{
    public function enter()
    {
        require_once __DIR__ . '/../controllers/user_logout.php';
    }
}