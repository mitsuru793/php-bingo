<?php
declare(strict_types=1);

namespace App\Domain\Game;

interface GameRepository
{
    /**
     * @return Game[]
     */
    public function findAll(): array;

    /**
     * @throws GameNotFoundException
     */
    public function findGameOfId(int $id): Game;

    /**
     */
    public function create(Game $game): Game;

    public function update(Game $game);
}
