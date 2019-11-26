<?php
declare(strict_types=1);

namespace App\Application\Actions\Game;

use App\Application\Actions\Action;
use App\Domain\Game\GameRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

abstract class GameAction extends Action
{
    /**
     * @var GameRepository
     */
    protected $gameRepository;

    /** @var UserRepository */
    protected $userRepository;

    public function __construct(LoggerInterface $logger, Twig $view, GameRepository $gameRepository, UserRepository $userRepository)
    {
        parent::__construct($logger, $view);
        $this->gameRepository = $gameRepository;
        $this->userRepository = $userRepository;
    }
}
