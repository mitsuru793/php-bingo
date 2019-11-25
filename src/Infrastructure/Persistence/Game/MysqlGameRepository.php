<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Game;

use App\Domain\Game\Game;
use App\Domain\Game\GameNotFoundException;
use App\Domain\Game\GameNumbers;
use App\Domain\Game\GameRepository;
use App\Models\Numbers;
use ParagonIE\EasyDB\EasyDB;

final class MysqlGameRepository implements GameRepository
{
    /** @var EasyDB */
    private $db;

    public function __construct(EasyDB $db)
    {
        $this->db = $db;
    }

    public function findAll(): array
    {
        $rows = $this->db->run('SELECT * FROM games');
        return $this->toGames($rows);
    }

    public function findGameOfId(int $id): Game
    {
        $row = $this->db->row('SELECT * FROM games WHERE id = ?', $id);
        if (!$row) {
            throw new GameNotFoundException();
        }
        return $this->toGame($row);
    }

    public function create(Game $game): Game
    {
        $id = $this->db->insertReturnId('games', [
            'numbers' => json_encode($game->numbers),
        ]);
        $game->id = $id;
        return $game;
    }

    /**
     * @return Game[]
     */
    private function toGames(array $rows): array
    {
        $games = array_map(function ($row) {
            return $this->toGame($row);
        }, $rows);
        return $games;
    }

    private function toGame(array $row): Game
    {
        $numbers = cast(json_decode($row['numbers']), function ($nums) {
            $all = new Numbers($nums->all);
            $left = new Numbers($nums->left);
            $hit = new Numbers($nums->hit);
            return new GameNumbers($all, $left, $hit);
        });
        return new Game($row['id'], $numbers);
    }
}
