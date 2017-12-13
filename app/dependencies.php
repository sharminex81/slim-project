<?php
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Monolog\Logger;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Monolog\Handler\StreamHandler;

//Initialize the container
$container = $app->getContainer();

/**
 * @param Container $container
 * @return \Slim\Views\Twig
 * @throws \Interop\Container\Exception\ContainerException
 */
$container['view'] = function (Container $container) {
    $settings = $container->get('settings');
    $twig = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);
    $twig->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    $twig->addExtension(new Twig_Extension_Debug());

    $twigEnvironment = $twig->getEnvironment();
    $twigEnvironment->addGlobal('session', $_SESSION);
    $twigEnvironment->addGlobal('config', $settings);

    return $twig;
};

/**
 * @param \Psr\Container\ContainerInterface $container
 * @return \Noodlehaus\Config
 */
$container['config'] = function (\Psr\Container\ContainerInterface $container) {
    return new \Noodlehaus\Config(dirname(__DIR__) . DIRECTORY_SEPARATOR . "config.php");
};

/**
 * @param Container $container
 * @return Logger
 * @throws \Interop\Container\Exception\ContainerException
 */
$container['logger'] = function (Container $container) {
    $config = $container->get('config');
    $logger = new Logger($config['app']['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\ProcessIdProcessor());
    $logger->pushProcessor(new \Monolog\Processor\PsrLogMessageProcessor());
    $logger->pushProcessor(new \Monolog\Processor\WebProcessor());
    $logger->pushHandler(new StreamHandler($config['app']['logger']['path']));

    return $logger;
};

/**
 * @param $container
 * @return \Slim\Flash\Messages
 */
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};


/**
 * @return \Slim\Flash\Messages
 */
$container['rana'] = function () {
    return new \Slim\Flash\Messages();
};

/**
 * @param \Psr\Container\ContainerInterface $container
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
$container['errorHandler'] = function (\Psr\Container\ContainerInterface $container) {
    $logger = $container->get('logger');
    $container['errorHandler'] = function ($container) use ($logger) {
        return function (Request $request, Response $response, Exception $exception) use (
            $container,
            $logger
        ) {
            $logger = $container->get('logger');
            $logger->error($exception->getMessage(), [$request->getQueryParams()]);
            $logger->debug($exception->getTraceAsString(), [$request->getQueryParams()]);
            return $container['view']->render($response->withStatus(500), '404.twig');
        };
    };
};

/**
 * @param $c
 * @return Closure
 */
$container['notFoundHandler'] = function ($c) {
    return function (Request $request, Response $response) use ($c) {
        $logger = $c->get('logger');
        $logger->info('Not Found', ['requested_uri' => $request->getUri()]);
        return $c['view']->render($response->withStatus(404), '404.twig');
    };
};

//Database configuration with illuminate Database
$capsule = new Capsule;

foreach ($container['settings']['databases'] as $key => $value) {
    $capsule->addConnection($value, $key);
}

$events = new Dispatcher(new \Illuminate\Container\Container());
$events->listen('Illuminate\Database\Events\QueryExecuted', function ($query) use ($container) {
    $logger = $container->get('logger');
    $logger->info(sprintf("[mysql_query] %s executed in %f milliseconds", $query->sql, $query->time),
        ['pdo_bindings' => $query->bindings]);
});

$capsule->setEventDispatcher($events);
$capsule->setAsGlobal();
$capsule->bootEloquent();

