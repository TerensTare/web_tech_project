<?php

require_once __DIR__ . '/../utils/route.php';

class NotFoundRoute extends Route
{
    public function enter()
    {
        require_once __DIR__ . '/../views/not_found.php';
    }
}

?>