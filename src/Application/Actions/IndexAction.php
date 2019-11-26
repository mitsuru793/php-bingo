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
        $game = new Game(1, null, $gameNumbers);
        if (!$game->isFinish()) {
            $gameNumbers->drawLots();
        }

        $game = [
            'numbers' => $gameNumbers,
        ];
        $this->session->set('game', json_decode(json_encode($game), true));

        $board = Board::create($size, $gameNumbers->hit);

        $this->view->render($this->response, 'index.twig', [
            'board' => $board,
        ]);
        return $this->response;
    }
}
