<?php

require_once 'utils/router.php';
// routes
require_once 'routes/game.php';
require_once 'routes/home.php';
require_once 'routes/login.php';
require_once 'routes/not_found.php';
require_once 'routes/signup.php';


$router = Router::create()
    ->route('/', new HomeRoute())
    ->route('/signup', new SignupRoute())
    ->route('/login', new LoginRoute())
    ->route('/play', new GameRoute())
    ->default(new NotFoundRoute());

$router->resolve();

?>