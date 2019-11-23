<?php
declare(strict_types=1);

namespace App\Domain\Game;

final class Game implements \JsonSerializable
{
    /** @var int|null */
    public $id;

    /** @var GameNumbers */
    public $numbers;

    public function __construct(?int $id, GameNumbers $numbers)
    {
        $this->id = $id;
        $this->numbers = $numbers;
    }

    public function drawLots(): self
    {
        $this->numbers->drawLots();
        return $this;
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
