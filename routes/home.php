<?php

require_once __DIR__ . '/../utils/route.php';

class HomeRoute extends Route
{
    public function enter()
    {
        require_once __DIR__ . '/../views/home.php';
    }
}