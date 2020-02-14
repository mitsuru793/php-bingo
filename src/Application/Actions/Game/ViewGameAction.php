<?php
declare(strict_types=1);

namespace App\Application\Actions\Game;

use Psr\Http\Message\ResponseInterface as Response;

final class ViewGameAction extends GameAction
{
    protected function action(): Response
    {
        $gameId = (int)$this->resolveArg('id');
        $game = $this->gameRepository->findGameOfId($gameId);
        $author = $this->userRepository->findUserOfId($game->authorId);

        $this->logger->info("Game of id `${gameId}` was viewed.");

        $this->view->render($this->response, 'game/view.twig', [
            'loginUser' => $this->loginUser,
            'game' => $game,
            'author' => $author,
        ]);
        return $this->response;
    }
}
