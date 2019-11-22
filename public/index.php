<?php
declare(strict_types=1);

use Php\Models\Element;
use Php\Models\Numbers;

require_once __DIR__ . '/../vendor/autoload.php';

/*
 * color palette: https://www.palettable.io/CF3D7E-7E3094-FFFFFF-427284-84B2C4
 */

function main()
{
    $size = 5;
    $nums = Numbers::create(1, $size * $size - 1)->shuffle();
    $rows = initTable($size, $nums);
    $hitNumbers = [1, 2, 3,];
    page($hitNumbers, $rows);
}


function initTable(int $size, Numbers $nums): array
{
    assert(isOdd($size));
    $center = (int)floor($size / 2) + 1;
    $centerI = $center - 1;

    $rows = [];
    for ($rowI = 0; $rowI < 5; $rowI++) {
        $row = [];
        for ($columnI = 0; $columnI < 5; $columnI++) {
            $isCenter = ($centerI === $rowI && $centerI === $columnI);
            $row[] = $isCenter ? 0 : $nums->pop();
        }
        $rows[] = $row;
    }

    $rows = array_map(function ($row) {
        return array_map(function (int $num) {
            $isHit = random([true, false]);
            return new Element($num, $isHit);
        }, $row);
    }, $rows);

    return $rows;
}

function page(array $hitNumbers, array $rows): void
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
        }
    </style>
    <?
}

function hitNumbersBox(array $hitNumbers): void
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

function board(array $rows): void
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
