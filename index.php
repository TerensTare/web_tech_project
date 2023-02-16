<?php

require_once __DIR__ . '/utils/router.php';
// routes
require_once __DIR__ . '/routes/admin.php';
require_once __DIR__ . '/routes/auth.php';
require_once __DIR__ . '/routes/game.php';
require_once __DIR__ . '/routes/home.php';
require_once __DIR__ . '/routes/not_found.php';


$router = Router::create()
    ->route('/', new HomeRoute())
    ->route('/admin', new AdminRoute())
    ->route('/auth', new AuthRoute())
    ->route('/play', new GameRoute())
    ->default(new NotFoundRoute());

$router->resolve();

?>