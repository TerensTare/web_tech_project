<?php
require_once __DIR__ . '/../utils/db.php';

class GameList
{
    public static function display()
    {
        self::load_games_list();
        $games = Db::self()->games()->rows();
        echo self::build_games_list($games);
    }

    private static function load_games_list()
    {
        $games_db = Db::self()->games();

        $games = json_decode(file_get_contents('games/games.json'), true);

        foreach ($games as $folder => $name) {
            if ($games_db->find([GamesTable::FOLDER => $folder]) === false)
                $games_db->insert([
                    GamesTable::NAME => $name,
                    GamesTable::FOLDER => $folder,
                ]);
        }

        return $games;
    }

    private static function build_games_list($games)
    {
        $count = sizeof($games);

        $html = "";

        for ($j = 0; $j < $count; $j += 3) {
            $html .= "<div class='row'>";

            $maxi = min(3, $count - $j);

            // i < 3 && j + i < count
            // i < 3 && i < count - j
            // i < min(3, count - j)
            for ($i = 0; $i < $maxi; $i++) {
                $game = $games[$j + $i];

                $html .= "<div class='col-3'>";
                $html .= "<div class='card rounded'>";
                $html .= "<img src='games/{$game[GamesTable::FOLDER]}/icon.png' class='card-img-top' alt='...'>";
                $html .= "<div class='card-body'>";
                $html .= "<h5 class='card-title'>{$game[GamesTable::NAME]}</h5>";
                $html .= "<a href='/play?id={$game[GamesTable::ID]}' class='btn btn-primary'>Play</a>";
                $html .= "</div>";
                $html .= "</div>";
                $html .= "</div>";
            }

            $html .= "</div>";
        }

        return $html;
    }
}
?>