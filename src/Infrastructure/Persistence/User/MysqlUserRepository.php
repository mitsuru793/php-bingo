<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\Board\BoardNotFoundException;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
use ParagonIE\EasyDB\EasyDB;

final class MysqlUserRepository implements UserRepository
{
    /** @var EasyDB */
    private $db;

    public function __construct(EasyDB $db)
    {
        $this->db = $db;
    }

    public function findUserOfId(int $id): User
    {

        $row = $this->db->row(<<<SQL
            SELECT * FROM users WHERE id = ?
        SQL, $id);
        if (!$row) {
            throw new BoardNotFoundException();
        }
        return $this->toUser($row);
    }

    private function toUser($row): User
    {
        $id = $row['id'] ? (int)$row['id'] : null;
        return new User($id, $row['name']);
    }
}
