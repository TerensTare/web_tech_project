<?php

require_once 'utils/route.php';

class LoginRoute extends Route
{
    public function enter()
    {
        require_once 'views/login.php';
    }
}

?>