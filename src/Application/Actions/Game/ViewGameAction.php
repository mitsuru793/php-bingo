<?php
declare(strict_types=1);

namespace App\Application\Actions\Game;

use App\Domain\Game\GameRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

final class ViewGameAction extends GameAction
{
    public function __construct(LoggerInterface $logger, Twig $view, GameRepository $gameRepository)
    {
        parent::__construct($logger, $view, $gameRepository);
    }

    protected function action(): Response
    {
        $gameId = (int)$this->resolveArg('id');
        $game = $this->gameRepository->findGameOfId($gameId);

        $this->logger->info("Game of id `${gameId}` was viewed");

        $this->view->render($this->response, 'index.twig', [
            'game' => $game,
        ]);
        return $this->response;
    }
}
