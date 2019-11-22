<?php
declare(strict_types=1);

namespace App\Models;

final class Game
{
    /** @var GameNumbers */
    public $numbers;

    public function __construct(GameNumbers $numbers)
    {
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
}
