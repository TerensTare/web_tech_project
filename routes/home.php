<?php

require_once 'utils/route.php';

class HomeRoute extends Route
{
    public function enter()
    {
        require_once 'views/home.php';
    }
}