<?php

const HTML_USERNAME_REGEX = '^.*[a-zA-Z0-9]{3,16}.*$';
const HTML_PASSWORD_REGEX = '^.*(?=[a-zA-Z0-9#,.\-_]{8,32})(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$';

const USERNAME_REGEX = '/' . HTML_USERNAME_REGEX . '/';
const PASSWORD_REGEX = '/' . HTML_PASSWORD_REGEX . '/';

?>