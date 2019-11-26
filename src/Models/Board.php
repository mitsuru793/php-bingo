<?php
declare(strict_types=1);

namespace App\Models;

final class Board
{
    /** @var int */
    public $id;

    /** @var Numbers */
    public $allNumbers;

    /** @var Numbers */
    public $hitNumbers;

    /** @var Rows */
    public $rows;

    public function __construct(?int $id, Numbers $allNumbers, Numbers $hitNumbers, Rows $rows)
    {
        $this->id = $id;
        $this->allNumbers = $allNumbers;
        $this->hitNumbers = $hitNumbers;
        $this->rows = $rows;
    }

    public static function create(int $size, Numbers $gameHitNumbers): self
    {
        $elementSize = $size * $size;
        $boardNums = Numbers::create(1, $elementSize - 1)->shuffle();
        return self::load(null, $boardNums, $gameHitNumbers);
    }

    public static function load(?int $id, Numbers $boardNumbers, Numbers $gameHitNumbers)
    {
        $boardHitNums = new Numbers();
        foreach ($gameHitNumbers as $hit) {
            $boardHitNums->push($hit);
        }

        $size = (int)sqrt(count($boardNumbers)) + 1;
        $rows = Rows::create($size, $boardNumbers, $gameHitNumbers);
        return new self($id, $boardNumbers, $boardHitNums, $rows);
    }

    public function __toString(): string
    {
        ob_start(); ?>
        <div class="board">
            <div class="rows">
                <? foreach ($this->rows as $row): ?>
                    <div class="row">
                        <? renderItems($row) ?>
                    </div>
                <? endforeach ?>
            </div>
        </div>
        <? return ob_get_clean();
    }
}
