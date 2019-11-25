<?php
declare(strict_types=1);

namespace App\Application\Actions;

use App\Domain\Game\Game;
use App\Domain\Game\GameNumbers;
use App\Models\Board;
use App\Models\Numbers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use SlimSession\Helper as SessionHelper;

final class IndexAction extends Action
{
    /** @var SessionHelper */
    private $session;

    public function __construct(LoggerInterface $logger, Twig $view, SessionHelper $session)
    {
        parent::__construct($logger, $view);
        $this->session = $session;
    }

    protected function action(): Response
    {
        $query = $this->request->getQueryParams();
        if ($query['reset'] ?? null) {
            $this->session->clear();
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
        $game = new Game(1, $gameNumbers);
        if (!$game->isFinish()) {
            $gameNumbers->drawLots();
        }

        $game = [
            'numbers' => $gameNumbers,
        ];
        $this->session->set('game', json_decode(json_encode($game), true));

        $board = Board::create($size, $gameNumbers->hit);
        $this->page($board);

        return $this->response;
    }

    private function page(Board $board): void
    {
        ?>
        <!doctype html>
        <html lang="ja">
        <head>
            <? $this->css() ?>
        </head>
        <body>
        <? $this->hitNumbersBox($board->hitNumbers) ?>
        <?= $board ?>
        </body>
        </html>
        <?
    }

    private function css(): void
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

    private function hitNumbersBox(Numbers $hitNumbers): void
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
}
