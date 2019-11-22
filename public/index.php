<?php
declare(strict_types=1);

use Php\Models\Board;
use Php\Models\GameNumbers;
use Php\Models\Numbers;
use Php\Models\Rows;

require_once __DIR__ . '/../vendor/autoload.php';

/*
 * color palette: https://www.palettable.io/CF3D7E-7E3094-FFFFFF-427284-84B2C4
 */

function main()
{
    $size = 5;
    $gameNumbers = GameNumbers::create($size, 1);

    $gameNumbers->hit = new Numbers(range(1, 5));

    $board = initBoard($size, $gameNumbers->hit);
    page($board->hitNumbers, $board->rows);
}

function initBoard(int $size, Numbers $gameHitNumbers): Board
{
    $elementSize = $size * $size;
    $boardNums = Numbers::create(1, $elementSize - 1)->shuffle();

    $boardHitNums = new Numbers();
    foreach ($gameHitNumbers as $hit) {
        $boardHitNums->push($hit);
    }

    $rows = Rows::create($size, $boardNums, $gameHitNumbers);
    $board = new Board($boardNums, $boardHitNums, $rows);

    return $board;
}

function page(Numbers $hitNumbers, Rows $rows): void
{
    ?>
    <!doctype html>
    <html lang="ja">
    <head>
        <? css() ?>
    </head>
    <body>
    <? hitNumbersBox($hitNumbers) ?>
    <? board($rows) ?>
    </body>
    </html>
    <?
}

function css(): void
{
    ?>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .hit-numbers-box > ol {
            display: flex;
            list-style-type: none;
        }

        .hit-numbers-box > ol > li {
            margin: 0.1rem;
            width: 1.5rem;
            background-color: #84B2C4;
            color: #FFFFFF;
            font-size: 0.5rem;
            line-height: 1.5rem;
            text-align: center;
        }

        .board {
            height: 20rem;
            width: 20rem;
            background-color: #CF3D7E;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rows {
        }

        .row {
            display: flex;
            flex-direction: row;
        }

        .element {
            margin: 0.2rem;
            width: 3rem;
            background-color: #84B2C4;
            color: #FFFFFF;
            font-size: 1rem;
            line-height: 3rem;
            text-align: center;
        }

        .element.hit {
            background-color: #427284;
            color: #D0D0D0;
        }
    </style>
    <?
}

function hitNumbersBox(Numbers $hitNumbers): void
{
    ?>
    <div class="hit-numbers-box">
        <ol>
            <? foreach ($hitNumbers as $n): ?>
                <li>
                    <div class="hit-number">
                        <?= $n ?>
                    </div>
                </li>
            <? endforeach ?>
        </ol>
    </div>
    <?
}

function board(Rows $rows): void
{
    ?>
    <div class="board">
        <div class="rows">
            <? foreach ($rows as $row): ?>
                <div class="row">
                    <? renderItems($row) ?>
                </div>
            <? endforeach ?>
        </div>
    </div>
    <?
}


main();
