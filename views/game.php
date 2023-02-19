<?php

require_once __DIR__ . '/../utils/db.php';
require_once __DIR__ . '/../utils/session.php';

class GameView
{
    private $game;

    private function __construct($id)
    {
        $this->game = Db::self()->games()->find([GamesTable::ID => $id]);

        // if ($this->game === false) {
        //     Session::redirect('/404');
        // }
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
    <h1>
        <?= $game[GamesTable::NAME] ?>
    </h1>
</body>

</html>