<?php

namespace Sharminshanta\Web\Accounts\Controller;

use Illuminate\Database\Capsule\Manager;
use Sharminshanta\Web\Accounts\Model\DefaultModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Database\Query\Builder;

/**
 * Class DefaultController
 * @package Sharminshanta\Web\Accounts\Controller
 */
class DefaultController extends AppController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function testView(ServerRequestInterface $request, ResponseInterface $response)
    {
        $message = $this->getFlash()->getMessages();

        $defaultModel = new DefaultModel();
        $users = $defaultModel->getAll();
        return $this->getView()->render($response, 'layouts/test.twig', [
            'message' => $message,
            'users' => $users
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return static
     * @var Builder
     */
    public function testPost(ServerRequestInterface $request, ResponseInterface $response)
    {
        $postData = $request->getParsedBody();

        if ($postData['password'] == '') {
            $this->getFlash()->addMessage('error', 'Password is null');
            $this->getLogger()->error('Password is null', ['postdata' => $postData]);
            return $response->withStatus(302)->withHeader('Location', $_SERVER['HTTP_REFERER']);
        }

        $defaultModel = new DefaultModel();
        $updateUser = $defaultModel->updateUser(14)->update($postData);
        //$createUser = $defaultModel->createNew($postData);
        $this->getLogger()->info('User has been created', ['postdata' => $postData]);
        $this->getFlash()->addMessage('success', 'User has been created');
        return $response->withStatus(302)->withHeader('Location', '/');
    }
}