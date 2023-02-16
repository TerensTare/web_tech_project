<?php

require_once 'utils/route.php';

class AuthRoute extends Route
{
    public function enter()
    {
        require_once 'views/auth.php';
    }
}

?>