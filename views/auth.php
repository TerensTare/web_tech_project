<?php

require_once 'utils/defs.php';

?>

<!DOCTYPE html>
<html>

<head>
    <title>Authenticate</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="views/auth.css">
</head>

<body>
    <?php

    if (isset($_GET['error']))
        echo '<div class="error">' . $_GET['error'] . '</div>';

    ?>

    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form method="post" action="./controllers/users.php">
                <input type="hidden" name="kind" value="signup">

                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="hidden" name="kind" value="signup">
                <input type="email" name="email" id="email" placeholder="user@mail.com" required>
                <input type="text" name="user" class="user" pattern="<?= USERNAME_REGEX ?>" placeholder="Username"
                    required>
                <input type="password" name="password" class="password" pattern="<?= PASSWORD_REGEX ?>"
                    placeholder="Password" required>

                <input type="submit" value="Signup" class="button">
                <input type="reset" value="Cancel" class="button">
            </form>
        </div>

        <div class="login">
            <form method="post" action="./controllers/users.php">
                <input type="hidden" name="kind" value="login">

                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="user" class="user" pattern="<?= USERNAME_REGEX ?>" placeholder="Username"
                    required>
                <input type="password" name="password" class="password" pattern="<?= PASSWORD_REGEX ?>"
                    placeholder="Password" required>

                <input type="submit" value="Login" class="button">
                <input type="reset" value="Cancel" class="button">
            </form>
        </div>
    </div>
</body>

</html>