<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        \SlimSession\Helper::class => function (ContainerInterface $c) {
            return new \SlimSession\Helper();
        },
        \Slim\Views\Twig::class => function (ContainerInterface $c) {
            $twig = new \Slim\Views\Twig(ROOT . '/templates', [
                'debug' => true,
                'cache' => ROOT . '/cache',
            ]);
            $twig->addExtension(new \Twig\Extension\DebugExtension());
            $twig->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension(
                $c->get(TranslatorInterface::class)
            ));
            return $twig;
        },
        TranslatorInterface::class => function (ContainerInterface $c) {
            $translator = new Translator('ja_JP');
            $loader = new \Symfony\Component\Translation\Loader\YamlFileLoader();
            $translator->addLoader('yaml', $loader);
            $translator->addResource('yaml', ROOT . '/locales/ja.yml', 'ja_JP');
            return $translator;
        },
    ]);
};
