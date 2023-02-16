<?php

require_once __DIR__ . '/../utils/route.php';

class AuthRoute extends Route
{
    public function enter()
    {
        require_once __DIR__ . '/../views/auth.php';
    }
}

?>