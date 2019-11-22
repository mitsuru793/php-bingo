<?php
declare(strict_types=1);

use App\Application\Actions\IndexAction;
use Slim\App;

return function (App $app) {
    $app->get('/', IndexAction::class);
};
