<?php
declare(strict_types=1);

namespace App\Application\Actions\Board;

use Psr\Http\Message\ResponseInterface as Response;

final class ListBoardsOfGameAction extends BoardAction
{
    protected function action(): Response
    {
        $gameId = (int)$this->resolveArg('id');
        $boards = $this->boardRepository->findBoardsOfGameId($gameId);
        $this->view->render($this->response, 'board/list_of_game.twig', [
            'boards' => $boards,
        ]);
        return $this->response;
    }
}
