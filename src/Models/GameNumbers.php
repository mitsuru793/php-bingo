<?php
declare(strict_types=1);

namespace Php\Models;

final class GameNumbers
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

    public function drawLots(): self
    {
        $hit = $this->left->pop();
        $this->hit->push($hit);
        return $this;
    }
}
