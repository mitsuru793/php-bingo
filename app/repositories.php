<?php
declare(strict_types=1);

use App\Domain\Game\GameRepository;
use App\Infrastructure\Persistence\Game\InMemoryGameRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        GameRepository::class => \DI\autowire(InMemoryGameRepository::class),
    ]);
};
