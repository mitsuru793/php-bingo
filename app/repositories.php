<?php
declare(strict_types=1);

use App\Domain\Board\BoardRepository;
use App\Domain\Board\MysqlBoardRepository;
use App\Domain\Game\GameRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Game\MysqlGameRepository;
use App\Infrastructure\Persistence\User\MysqlUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(MysqlUserRepository::class),
    ]);
    $containerBuilder->addDefinitions([
        GameRepository::class => \DI\autowire(MysqlGameRepository::class),
    ]);
    $containerBuilder->addDefinitions([
        BoardRepository::class => \DI\autowire(MysqlBoardRepository::class),
    ]);
};
