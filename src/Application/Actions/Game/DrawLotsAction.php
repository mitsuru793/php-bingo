<?php
declare(strict_types=1);

namespace App\Application\Actions\Game;

use Psr\Http\Message\ResponseInterface as Response;

final class DrawLotsAction extends GameAction
{
    protected function action(): Response
    {
        $gameId = (int)$this->resolveArg('id');
        $game = $this->gameRepository->findGameOfId($gameId);

        $hitNumber = $game->drawLots();
        $this->gameRepository->update($game);

        $this->logger->info("Game of id `${gameId}` hits number `{$hitNumber}`.");

        $this->view->render($this->response, 'game.twig', [
            'game' => $game,
        ]);
        return $this->response;
    }
}
