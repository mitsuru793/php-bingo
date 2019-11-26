<?php
declare(strict_types=1);

use App\Domain\Board\BoardRepository;
use App\Domain\Board\MysqlBoardRepository;
use App\Domain\Game\GameRepository;
use App\Infrastructure\Persistence\Game\MysqlGameRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        GameRepository::class => \DI\autowire(MysqlGameRepository::class),
    ]);
    $containerBuilder->addDefinitions([
        BoardRepository::class => \DI\autowire(MysqlBoardRepository::class),
    ]);
};
