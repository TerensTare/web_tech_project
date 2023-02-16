<?php

require_once 'utils/router.php';
// routes
require_once 'routes/admin.php';
require_once 'routes/auth.php';
require_once 'routes/game.php';
require_once 'routes/home.php';
require_once 'routes/not_found.php';


$router = Router::create()
    ->route('/', new HomeRoute())
    ->route('/admin', new AdminRoute())
    ->route('/auth', new AuthRoute())
    ->route('/play', new GameRoute())
    ->default(new NotFoundRoute());

$router->resolve();

?>