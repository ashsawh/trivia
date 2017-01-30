<?php
namespace App\Services;

use App\Models\Games as GamesModel;
use App\Library\AService;

class Games extends AService
{
    public function store(array $payload)
    {
        try {
            $this->validator->setInput($payload)->run();
            $game = new GamesModel($payload);
            $game->save();
            $this->cache->hmset("game:{$game->id}", $game->toArray());
            return $game;
        } catch (\Exception $ex) {
            return '';
        }
    }

    public function retrieve($gameId)
    {
        try {
            $cacheKey = "game:{$gameId}";
            $this->validator->setInput(array('id' => $gameId))->run();
            if ($this->cache->exists($cacheKey)) {
                $game = $this->cache->hgetall($cacheKey);
            } else {
                $game = GamesModel::find($gameId);
            }
            return $game;
        } catch (\Exception $e) {

        }
    }

    public function modify(array $payload, $gameId)
    {
        try {
            $this->validator->setInput(array_merge($payload, array('id' => $gameId)))->run();
            $game = GamesModel::find($gameId);
            if ($game) {
                foreach ($payload as $k => $v) {
                    $game->$k = $v;
                }
                $game->save();
                $this->cache->hmset("game:{$game->id}", $game->toArray());
            }
            return $game;
        } catch (\Exception $ex) {
            return '';
        }
    }

    public function remove($gameId)
    {
        try {
            $cacheKey = "game:{$gameId}";
            $this->validator->setInput(array('id' => $gameId))->run();
            $game = GamesModel::find($gameId);
            $game->delete();
            $this->cache->del($cacheKey);
        } catch (\Exception $ex) {
            return '';
        }
    }
}