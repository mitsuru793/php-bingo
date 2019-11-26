<?php
declare(strict_types=1);


use App\Application\Actions\Board\ListBoardsOfGameAction;
use App\Application\Actions\Board\ViewBoardAction;
use App\Application\Actions\Game\DrawLotsAction;
use App\Application\Actions\Game\ListGamesAction;
use App\Application\Actions\Game\ViewGameAction;
use App\Application\Actions\IndexAction;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', IndexAction::class);

    $app->group('/games', function (Group $group) {
        $group->get('', ListGamesAction::class);
        $group->get('/{id}', ViewGameAction::class);
        $group->post('/{id}:drawLots', DrawLotsAction::class);
        $group->get('/{id}/boards', ListBoardsOfGameAction::class);
    });

    $app->group('/boards', function (Group $group) {
        $group->get('/{id}', ViewBoardAction::class);
    });
};
