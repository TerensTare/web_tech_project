<?php
require_once __DIR__ . '/../utils/db.php';

class GameList
{
    public static function build(?string $filter = null): string
    {
        self::load_games_list();
        $games = $filter ? Db::self()->game_tags_rel()->withTag($filter)
            : Db::self()->games()->rows();
        return self::build_games_list($games);
    }

    private static function load_games_list()
    {
        $games_db = Db::self()->games();

        $games = json_decode(file_get_contents('games/games.json'), true);

        foreach ($games as $game) {
            if ($games_db->find([GamesTable::FOLDER => $game[GamesTable::FOLDER]]) !== false)
                continue;

            $gid = $games_db->insert([
                GamesTable::NAME => $game[GamesTable::NAME],
                GamesTable::FOLDER => $game[GamesTable::FOLDER],
            ]);

            $tags_db = Db::self()->tags();
            $game_tags_rel_db = Db::self()->game_tags_rel();

            foreach ($game['tags'] as $tag) {
                $tag_id = $tags_db->insert([TagsTable::NAME => $tag])[TagsTable::ID];

                $game_tags_rel_db->insert([
                    GameTagsTable::GAME_ID => $gid[GamesTable::ID],
                    GameTagsTable::TAG_ID => $tag_id
                ]);
            }
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
                $html .= "<div class='card-body text-center'>";
                $html .= "<h5 class='card-title mb-3'>{$game[GamesTable::NAME]}</h5>";
                $html .= "<a href='/play?id={$game[GamesTable::ID]}' class='btn btn-primary mb-3'>Play</a>";
                $html .= "<div class='tags'>";
                $tags = Db::self()->game_tags_rel()->tagsOf($game[GamesTable::NAME]);
                foreach ($tags as $tag) {
                    $html .= "<a href='/?filter={$tag[TagsTable::NAME]}' class='badge rounded-pill bg-danger ms-2'>{$tag[TagsTable::NAME]}</a>";
                }
                $html .= "</div>";
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