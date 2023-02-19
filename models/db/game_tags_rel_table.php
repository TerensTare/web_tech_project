<?php

require_once __DIR__ . '/table.php';

class GameTagsTable extends Table
{
    public const GAME_ID = "game_id";
    public const TAG_ID = "tag_id";

    public function __construct(PDO $handle)
    {
        parent::__construct($handle);
    }

    public function name(): string
    {
        return "game_tags_rel";
    }

    public function columns(): array
    {
        return [self::GAME_ID, self::TAG_ID];
    }

    public function primary_key(): string
    {
        $gid = self::GAME_ID;
        $tid = self::TAG_ID;
        return "`{$gid}`, `{$tid}`";
    }

    public function withTag(string $tag): array
    {
        $stmt = "SELECT `g`.*
            FROM `games` g, `game_tags_rel` gtr, `tags` t
            WHERE gtr.`game_id` = g.`id` AND gtr.`tag_id` = t.`id` AND t.`name` = :tag;";
        $query = $this->handle->prepare($stmt);
        $query->execute(['tag' => $tag]);
        return $query->fetchAll();
    }

    public function tagsOf(string $game): array
    {
        $stmt = "SELECT `t`.*
            FROM `games` g, `game_tags_rel` gtr, `tags` t
            WHERE gtr.`game_id` = g.`id` AND gtr.`tag_id` = t.`id` AND g.`name` = :game;";
        $query = $this->handle->prepare($stmt);
        $query->execute(['game' => $game]);
        return $query->fetchAll();
    }
}