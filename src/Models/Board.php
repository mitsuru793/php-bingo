<?php
declare(strict_types=1);

namespace Php\Models;

final class Board
{
    /** @var Numbers */
    public $allNumbers;

    /** @var Numbers */
    public $hitNumbers;

    /** @var Rows */
    public $rows;

    public function __construct(Numbers $allNumbers, Numbers $hitNumbers, Rows $rows)
    {
        $this->allNumbers = $allNumbers;
        $this->hitNumbers = $hitNumbers;
        $this->rows = $rows;
    }

    public static function create(int $size, Numbers $gameHitNumbers): self
    {
        $elementSize = $size * $size;
        $boardNums = Numbers::create(1, $elementSize - 1)->shuffle();

        $boardHitNums = new Numbers();
        foreach ($gameHitNumbers as $hit) {
            $boardHitNums->push($hit);
        }

        $rows = Rows::create($size, $boardNums, $gameHitNumbers);
        $board = new self($boardNums, $boardHitNums, $rows);

        return $board;
    }
}
