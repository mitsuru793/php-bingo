<?php
declare(strict_types=1);

use Php\Models\Board;
use Php\Models\Game;
use Php\Models\GameNumbers;
use Php\Models\Numbers;

require_once __DIR__ . '/../vendor/autoload.php';

/*
 * color palette: https://www.palettable.io/CF3D7E-7E3094-FFFFFF-427284-84B2C4
 */

function main()
{
    session_start();
    if ($_GET['reset'] ?? null) {
        session_destroy();
    }

    $size = 5;
    $game = $_SESSION['game'] ?? null;
    if (is_null($game)) {
        $gameNumbers = GameNumbers::create($size, 1);
    } else {
        $nums = $game['numbers'];
        $gameNumbers = new GameNumbers(
            new Numbers($nums['all']),
            new Numbers($nums['left']),
            new Numbers($nums['hit']),
        );
    }
    $game = new Game($gameNumbers);
    if (!$game->isFinish()) {
        $gameNumbers->drawLots();
    }

    $board = Board::create($size, $gameNumbers->hit);

    $game = [
        'numbers' => $gameNumbers,
    ];
    $_SESSION['game'] = json_decode(json_encode($game), true);

    page($board);
}

function page(Board $board): void
{
    ?>
    <!doctype html>
    <html lang="ja">
    <head>
        <? css() ?>
    </head>
    <body>
    <? hitNumbersBox($board->hitNumbers) ?>
    <?= $board ?>
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

main();
