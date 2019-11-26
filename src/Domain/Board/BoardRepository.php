<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Models\Board;

interface BoardRepository
{
    /**
     * @throws BoardNotFoundException
     */
    public function findBoardOfId(int $id): Board;

    /**
     * @return Board[]
     */
    public function findBoardsOfGameId(int $id): array;
}
