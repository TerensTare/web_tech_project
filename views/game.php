<?php

require_once __DIR__ . '/utils/db.php';
require_once __DIR__ . '/utils/session.php';

class GameView
{
    private $game;

    private function __construct($id)
    {
        $this->game = Db::self()->games()->find([GamesTable::ID => $id]);

        if ($this->game === false) {
            Session::flash('game', 'Game not found');
            Session::redirect('/');
        }
    }

    public static function load($id)
    {
        return (new GameView($id))->game;
    }
}

$game = GameView::load($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $game[GamesTable::NAME] ?>
    </title>
    <style>
        body {
            margin: 0px;
            padding: 0px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        canvas {
            box-shadow: black 20px 10px 50px;
        }
    </style>
</head>

<body>
    <canvas id="game" width="600" height="650"></canvas>
    <script src="games/<?= $game[GamesTable::FOLDER] ?>/index.js"></script>
</body>

</html>