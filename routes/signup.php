<?php

require_once 'utils/route.php';

class SignupRoute extends Route
{
    public function enter()
    {
        require_once 'views/signup.php';
    }
}

?>