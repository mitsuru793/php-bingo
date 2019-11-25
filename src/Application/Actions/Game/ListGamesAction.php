<?php
declare(strict_types=1);

namespace App\Application\Actions\Game;

use Psr\Http\Message\ResponseInterface as Response;

final class ListGamesAction extends GameAction
{
    protected function action(): Response
    {
        $games = $this->gameRepository->findAll();

        $this->logger->info("Games were viewed.");

        $this->view->render($this->response, 'game/list.twig', [
            'games' => $games,
        ]);
        return $this->response;
    }
}
