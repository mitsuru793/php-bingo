<?php
declare(strict_types=1);

namespace App\Domain\Game;

use App\Models\Numbers;

final class GameNumbers implements \JsonSerializable
{
    /** @var Numbers */
    public $all;

    /** @var Numbers */
    public $left;

    /** @var Numbers */
    public $hit;

    public function __construct(Numbers $all, Numbers $left, Numbers $hit)
    {
        $this->all = $all;
        $this->left = $left;
        $this->hit = $hit;
    }

    public static function create(int $boardSize, int $numberStockRation): self
    {
        assert($boardSize > 0);
        assert($numberStockRation >= 1);

        $elementSize = $boardSize * $boardSize;
        $end = (int)$elementSize * $numberStockRation - 1;
        $all = Numbers::create(1, $end)->shuffle();
        $left = clone $all;
        $left = $left->shuffle();
        $hits = new Numbers();

        return new GameNumbers($all, $left, $hits);
    }

    public function drawLots(): int
    {
        $hit = $this->left->pop();
        $this->hit->push($hit);
        return $hit;
    }

    public function jsonSerialize()
    {
        return [
            'all' => $this->all,
            'left' => $this->left,
            'hit' => $this->hit,
        ];
    }
}
