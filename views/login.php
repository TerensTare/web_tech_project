<?php

require_once 'utils/defs.php';

?>

<html>

<body>
    <form action="./controllers/users.php" method="post">
        <input type="hidden" name="kind" value="login">

        <label for="user">Name</label>
        <input type="text" name="user" id="user" pattern="<?= USERNAME_REGEX ?>" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" pattern="<?= PASSWORD_REGEX ?>" required>

        <input type="submit" id="login" value="Login">
        <input type="reset" value="Cancel">
    </form>
</body>

</html>