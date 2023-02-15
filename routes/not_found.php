<?php

require_once 'utils/route.php';

class NotFoundRoute extends Route
{
    public function enter()
    {
        require_once 'views/not_found.php';
    }
}

?>