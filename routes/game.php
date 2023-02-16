<?php

require_once __DIR__ . '/../utils/route.php';

class GameRoute extends Route
{
    public function enter()
    {
        require_once __DIR__ . '/../views/game.php';
    }
}