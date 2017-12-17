<?php

namespace Sharminshanta\Web\Accounts\Middleware;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AuthMiddleware
 * @package Sharminshanta\Web\Accounts\Middleware
 */
class AuthMiddleware
{
    /**
     * @var
     */
    protected $logger;

    /**
     * @var
     */
    protected $config;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->config = $container->get('config');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return Response|static
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        /**
         * This is just for testing
         */
        if (!$_SESSION['auth']) {
            $this->logger->info('Someone Tried to Access Admin  Section', ['userInfo' => null]);
            return $response->withStatus(302)->withRedirect('/');
        }

        $response = $next($request, $response);
        return $response;
    }

}