<?php
declare(strict_types=1);

namespace App\Domain\Game;

final class Game implements \JsonSerializable
{
    /** @var int|null */
    public $id;

    /** @var int|null */
    public $authorId;

    /** @var GameNumbers */
    public $numbers;

    public function __construct(?int $id, ?int $authorId, GameNumbers $numbers)
    {
        $this->id = $id;
        $this->numbers = $numbers;
        $this->authorId = $authorId;
    }

    public function drawLots(): int
    {
        return $this->numbers->drawLots();
    }

    public function isFinish(): bool
    {
        return $this->numbers->left->isEmpty();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'numbers' => $this->numbers,
        ];
    }
}
