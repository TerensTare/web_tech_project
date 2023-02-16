<?php

require_once 'utils/route.php';

class GameRoute extends Route
{
    public function enter()
    {
        require_once 'views/game.php';
    }
}