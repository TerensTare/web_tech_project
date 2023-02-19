<?php

if (isset($_POST['logout']) && isset($_SESSION['auth'])) {
    session_unset();
    session_destroy();
    unset($_SESSION);
}

header("Location: /");

?>