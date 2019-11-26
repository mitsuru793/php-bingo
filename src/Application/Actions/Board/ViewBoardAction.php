<?php
declare(strict_types=1);

namespace App\Application\Actions\Board;

use Psr\Http\Message\ResponseInterface as Response;

final class ViewBoardAction extends BoardAction
{
    protected function action(): Response
    {
        $boardId = (int)$this->resolveArg('id');
        $board = $this->boardRepository->findBoardOfId($boardId);
        $this->view->render($this->response, 'index.twig', [
            'board' => $board,
        ]);
        return $this->response;
    }
}
