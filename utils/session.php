<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Session
{
    public static function redirect($loc)
    {
        header('Location:' . $loc);
        exit();
    }
}

?>