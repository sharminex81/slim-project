<?php

namespace Sharminshanta\Web\Accounts\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class Auth
 * @package Sharminshanta\Web\Accounts\Middleware
 */
class Auth
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return Response|static
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        if (!$_SESSION['auth']) {
            return $response->withStatus(302)->withRedirect('/');
        }

        $response = $next($request, $response);
        return $response;
    }

}