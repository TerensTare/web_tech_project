<?php

require_once __DIR__ . '/../utils/route.php';

class UserPanelRoute extends Route
{
    public function enter()
    {
        require_once __DIR__ . '/../views/user_panel.php';
    }
}

?>