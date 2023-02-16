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

    public static function flash(string $name, string $message)
    {
        $_GET['error'] = $message;
    }

// public static function flash($name = '', $message = '', $class = 'form-message form-message-red')
// {
//     if (!empty($name)) {
//         if (!empty($message) && empty($_SESSION[$name])) {
//             $_SESSION[$name] = $message;
//             $_SESSION[$name . '_class'] = $class;
//         } else if (empty($message) && !empty($_SESSION[$name])) {
//             $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : $class;
//             echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
//             unset($_SESSION[$name]);
//             unset($_SESSION[$name . '_class']);
//         }
//     }
// }

}

?>