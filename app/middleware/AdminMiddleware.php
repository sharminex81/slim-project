<?php

namespace Sharminshanta\Web\Accounts\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AdminMiddleware
 * @package Sharminshanta\Web\Accounts\Middleware
 */
class AdminMiddleware
{

    /**
     * @var mixed
     */
    protected $logger;

    /**
     * @var mixed
     */
    protected $config;

    /**
     * @var array
     */
    protected $adminPortalEmails = [];

    /**
     * AuthMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->config = $container->get('config');
        if (array_key_exists('portal_admin', $this->config['app']) && $this->config['app']['portal_admin']) {
            $this->adminPortalEmails = $this->config['app']['portal_admin'];
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     * @return ResponseInterface|static
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        /*if (empty($this->adminPortalEmails)) {
            $this->logger->info('sorry', ['sorry' => 'sorry']);
        }*/

        if ($_SESSION['auth'] && in_array($_SESSION['auth']['userinfo']['email'], $this->adminPortalEmails)) {
            $_SESSION['is_admin'] = true;
            $response = $next($request, $response);
            return $response;
        }

        if(!$_SESSION['auth']){
            $response = $next($request, $response);
            return $response;
        }

        $this->logger->info('Someone Tried to Access Career\'s Admin  Section', ['userinfo' => $_SESSION['auth']['userinfo']]);
        return $response->withStatus(403)->withHeader('Location', '/');
    }
}