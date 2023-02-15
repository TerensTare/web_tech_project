<?php

const USERNAME_REGEX = '/^[a-zA-Z0-9]{3,16}$/';
const PASSWORD_REGEX = '/^.*(?=[a-zA-Z0-9#,.\-_]{8,32})(?=(?:.*?[a-zA-Z]){6,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/';

?>