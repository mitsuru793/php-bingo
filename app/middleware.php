<?php
declare(strict_types=1);

use Slim\App;

return function (App $app) {
    $app->add(new \Slim\Middleware\Session());
    $app->add(\App\Application\Middlewares\LoginAuth::class);
};
