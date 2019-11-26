<?php
declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    public function findUserOfId(int $id): User;
}
