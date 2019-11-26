<?php
declare(strict_types=1);

namespace App\Application\Actions\Board;

use App\Application\Actions\Action;
use App\Domain\Board\BoardRepository;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

abstract class BoardAction extends Action
{
    /** @var BoardRepository */
    protected $boardRepository;

    /** @var Twig */
    protected $view;

    public function __construct(LoggerInterface $logger, Twig $view, BoardRepository $boardRepository)
    {
        parent::__construct($logger, $view);
        $this->boardRepository = $boardRepository;
    }
}
