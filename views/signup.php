<?php

require_once 'utils/session.php';

?>

<h1>Signup</h1>

<form action="./controllers/users.php" method="post">
    <input type="hidden" name="kind" value="signup">

    <input type="email" name="email" id="email" placeholder="user@mail.com" required>

    <input type="text" name="user" id="user" pattern="<?php USERNAME_REGEX ?>" placeholder="Username" required>

    <input type="password" name="password" id="password" pattern="<?php PASSWORD_REGEX ?>" placeholder="Password"
        required>

    <input type="submit" id="login" value="Login">
    <input type="reset" value="Cancel">

</form>