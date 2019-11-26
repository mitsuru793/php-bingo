<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Models\Board;
use App\Models\Numbers;
use ParagonIE\EasyDB\EasyDB;

final class MysqlBoardRepository implements BoardRepository
{
    /** @var EasyDB */
    private $db;

    public function __construct(EasyDB $db)
    {
        $this->db = $db;
    }

    public function findBoardOfId(int $id): Board
    {
        $row = $this->db->row(<<<SQL
            SELECT boards.*, games.numbers as game_numbers
            FROM boards
            INNER JOIN games ON boards.game_id = games.id 
            WHERE boards.id = ?
        SQL, $id);
        if (!$row) {
            throw new BoardNotFoundException();
        }
        return $this->toBoard($row);
    }

    private function toBoard(array $row): Board
    {
        $id = $row['id'] ? (int)$row['id'] : null;
        $boardNums = jsonCast($row['numbers'], function ($nums) {
            return new Numbers($nums);
        });
        $gameHits = jsonCast($row['game_numbers'], function ($nums) {
            return new Numbers($nums->hit);
        });
        return Board::load($id, $boardNums, $gameHits);
    }
}
