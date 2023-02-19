<?php

require_once __DIR__ . '/../utils/route.php';
require_once __DIR__ . '/../utils/session.php';

class AdminRoute extends Route
{
    public function enter()
    {
        require_once __DIR__ . '/../views/admin.php';
    }
}

?>