<?php
declare(strict_types=1);

namespace Php\Models;

final class GameNumbers
{
    /** @var Numbers */
    public $all;

    /** @var Numbers */
    public $hit;

    public function __construct(Numbers $all, Numbers $hit)
    {
        $this->all = $all;
        $this->hit = $hit;
    }

    public static function create(int $boardSize, int $numberStockRation): self
    {
        assert($boardSize > 0);
        assert($numberStockRation >= 1);

        $elementSize = $boardSize * $boardSize;
        $end = (int)$elementSize * $numberStockRation - 1;
        $nums = Numbers::create(1, $end)->shuffle();
        $hits = new Numbers();

        return new GameNumbers($nums, $hits);
    }
}
