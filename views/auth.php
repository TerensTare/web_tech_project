<?php

require_once __DIR__ . '/../utils/defs.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="views/auth.css">

    <title>Authenticate</title>
</head>

<body>
    <div class="center">
        <?php

        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>

        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="signup">
                <form method="post" action="./controllers/user_signup.php">
                    <label for="chk" aria-hidden="true">Sign up</label>

                    <input type="email" name="email" id="email" placeholder="user@mail.com"
                        required>
                    <input type="text" name="s-username" id="s-username" pattern="<?= HTML_USERNAME_REGEX ?>"
                        placeholder="Username" required>
                    <input type="password" name="s-password" id="s-password" pattern="<?= HTML_PASSWORD_REGEX ?>"
                        placeholder="Password" required>

                    <input type="submit" value="Signup">
                    <input type="reset" value="Cancel">
                </form>
            </div>

            <div class="login">
                <form method="post" action="./controllers/user_login.php">
                    <label for="chk" aria-hidden="true">Login</label>

                    <input type="text" name="l-username" id="l-username" pattern="<?= HTML_USERNAME_REGEX ?>"
                        placeholder="Username" required>
                    <input type="password" name="l-password" id="l-password" pattern="<?= HTML_PASSWORD_REGEX ?>"
                        placeholder="Password" required>

                    <input type="submit" value="Login">
                    <input type="reset" value="Cancel">
                </form>
            </div>
        </div>
    </div>
</body>

</html>