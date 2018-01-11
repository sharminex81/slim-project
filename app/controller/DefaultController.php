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
        //$updateUser = $defaultModel->updateUser(2)->update($postData);
        $createUser = $defaultModel->createNew($postData);
        $this->getLogger()->info('User has been created', ['postdata' => $postData]);
        $this->getFlash()->addMessage('success', 'User has been created');
        return $response->withStatus(302)->withHeader('Location', '/');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function createMessage(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->getView()->render($response, 'help/send-message.twig',
            ['message' => $this->getFlash()->getMessages()]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return static
     */
    public function saveMessage(ServerRequestInterface $request, ResponseInterface $response)
    {
        $postData = $request->getParsedBody();

        //Validate recaptcha response
        /*if (!empty($postData['g-recaptcha-response'])) {
            $this->getLogger()->info("Verifying captcha", ['user_data' => $postData]);
            $captchaResponse = $this->getRecaptcha()->verify($postData['g-recaptcha-response'], VisitorIP::getIP());
            $this->getLogger()->info("Captcha display result " . $captchaResponse->isSuccess(),
                ['user_details' => $postData]);

            if (!$captchaResponse->isSuccess()) {
                $this->getLogger()->info("Captcha verification failed" . $captchaResponse->isSuccess(),
                    ['user_details' => $postData]);
                $this->getFlash()->addMessage('error', 'Incorrect captcha. Prove us you are human');
                return $response->withRedirect($request->getServerParam('HTTP_REFERER'));
            }
        } else {
            $this->getLogger()->info("Captcha response empty");
            $this->getFlash()->addMessage('error', 'Please verify captcha to send message');
            return $response->withRedirect($request->getServerParam('HTTP_REFERER'));
        }*/

        if (array_key_exists('name', $postData)
            && $postData['name'] != ''
            && array_key_exists('email_address', $postData)
            && $postData['email_address'] != ''
            && array_key_exists('message', $postData)
            && $postData['message'] != ''
            && array_key_exists('subject', $postData)
            && $postData['subject'] != '') {
            $this->sendMailToMessageSender($postData);
            $this->getFlash()->addMessage('success',
                'We have received your message. Our team will get back to you via your email. Thanks again!');
        } else {
            $this->getFlash()->addMessage('error',
                'Sorry, we couldn\'t receive your message right now. Please try again later. Sorry for this inconvenience');
        }

        return $response->withStatus(302)->withHeader('Location', '/send-message');
    }

    /**
     * @param $postData
     */
    private function sendMailToMessageSender($postData)
    {
        $data = [
            'sender' => $postData,
            'settings' => $this->getSettings()
        ];

        // Send email to sender
        $senderMsg = $this->getView()->fetch('emails/send-message.twig', ['data' => $data]);
        $sender = [
            [
                'name' => $data['sender']['name'],
                'email_address' => $data['sender']['email_address']
            ]
        ];
        $this->getEmail()->sendEmail($sender, 'Message has been received - Sharmin Shanta', $senderMsg);

        /*// Send email to admin
        $adminEmails = null;
        if (isset($this->getSettings()['admin_notification_email']) && array_key_exists('recipients',
                $this->getSettings()['admin_notification_email'])) {
            $adminEmails = $this->getSettings()['admin_notification_email']['recipients'];
        }
        if ($adminEmails) {
            $adminMsg = $this->getView()->fetch('emails/send-message-admin.twig', ['data' => $data]);
            $this->getEmail()->sendEmail($adminEmails, 'New message has been received - Preview Technologies Limited', $adminMsg);
        }*/
    }
}