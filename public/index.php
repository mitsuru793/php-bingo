<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

/*
 * color palette: https://www.palettable.io/CF3D7E-7E3094-FFFFFF-427284-84B2C4
 */

function main()
{
    $size = 5;
    $rows = initTable($size);
    page($rows);
}


function initTable(int $size): array
{
    $nums = range(1, 5 * 5 - 1);
    shuffle($nums);

    assert(isOdd($size));
    $center = (int)floor($size / 2) + 1;
    $centerI = $center - 1;

    $rows = [];
    for ($rowI = 0; $rowI < 5; $rowI++) {
        $row = [];
        for ($columnI = 0; $columnI < 5; $columnI++) {
            $isCenter = ($centerI === $rowI && $centerI === $columnI);
            $row[] = $isCenter ? 0 : array_pop($nums);
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

function page(array $rows): void
{
    ?>
    <!doctype html>
    <html lang="ja">
    <head>
        <? css() ?>
    </head>
    <body>
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

final class Element
{
    /** @var int */
    public $number;

    /** @var bool */
    public $isHit;

    /** @var bool */
    public $isCenter;

    public function __construct(int $number, bool $isHit)
    {
        $this->number = $number;
        $this->isHit = $isHit;
        $this->isCenter = $this->number === 0;
    }

    public function __toString(): string
    {
        ob_start(); ?>
        <div class="element <?= isT($this->isCenter, 'center') ?> <?= isT($this->isHit, 'hit') ?> ">
            <?= $this->isCenter ? 'Free' : $this->number ?>
        </div>
        <? return ob_get_clean();
    }
}

main();
