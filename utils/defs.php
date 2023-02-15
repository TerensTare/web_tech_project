<?php

define('USERNAME_REGEX', '/^[a-zA-Z0-9]{3,16}$/');
define('PASSWORD_REGEX', '/^.*(?=[a-zA-Z0-9#,.\-_]{10,})(?=(?:.*?[a-zA-Z]){6,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/');

?>