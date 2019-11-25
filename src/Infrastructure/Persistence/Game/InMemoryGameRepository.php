<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Game;

use App\Domain\Game\Game;
use App\Domain\Game\GameNotFoundException;
use App\Domain\Game\GameNumbers;
use App\Domain\Game\GameRepository;

class InMemoryGameRepository implements GameRepository
{
    /** @var Game[] */
    private $games;

    /** @var int */
    private $nextId = 1;

    public function __construct(array $games = null)
    {
        $nums = GameNumbers::create(5, 2);
        $this->games = $games ?? [
                1 => new Game(1, clone $nums),
                2 => new Game(2, clone $nums),
                3 => new Game(3, clone $nums),
            ];
        foreach ($this->games as $game) {
            for ($i = 0; $i < rand(0, 10); $i++) {
                $game->drawLots();
            }
        }
        $this->nextId = count($this->games) + 1;
    }

    public function findAll(): array
    {
        return array_values($this->games);
    }

    public function findGameOfId(int $id): Game
    {
        if (!isset($this->games[$id])) {
            throw new GameNotFoundException();
        }

        return $this->games[$id];
    }

    public function create(Game $game): Game
    {
        $this->games[$this->nextId] = $game;
        $game->id = $this->nextId;
        $this->nextId++;
        return $game;
    }
}
