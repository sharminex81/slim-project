<?php

namespace Sharminshanta\Web\Accounts\Controller;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class Email
 * @package Sharminshanta\Web\Accounts\Controller
 */
class Email
{
    /**
     * @var Logger
     */
    public $logger;

    /**
     * @var mixed
     */
    public $config;

    /**
     * Email constructor.
     * @param $config
     */
    public function __construct($config, LoggerInterface $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * @param $recipients
     * @param $subject
     * @param $message
     * @param array $cc
     * @param array $bcc
     * @return bool
     */
    function sendEmail($recipients, $subject, $message, $cc = [], $bcc = [])
    {
        $emailBody = [
            'message' => [
                'from_name' => 'Sharmin Shanta',
                'from_email_address' => 'sharmin@previewtechs.com',
                'recipients' => $recipients,
                'subject' => $subject,
                'html' => $message
            ]
        ];

        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->config['app']['send_email_api_endpint'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($emailBody),
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: 8328da32-6f1f-a344-c87e-1626b54c33fe"
                ),
            ));

            $response = json_decode(curl_exec($curl), true);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                $this->logger->info('Sending Email Failed', ['recipients' => $recipients, 'cc' => $cc, 'bcc' => $bcc]);
            }

            if (array_key_exists('error', $response) && $response['error']) {
                $this->logger->info($response['error'], ['message' => $response['message'], 'recipients' => $recipients, 'cc' => $cc, 'bcc' => $bcc]);
                return false;
            } else {
                $this->logger->info('Email Has Been Sent', ['recipients' => $recipients, 'cc' => $cc, 'bcc' => $bcc]);
                return true;
            }

        } catch (\Exception $exception) {
            $this->logger->info($exception->getMessage(), ['recipients' => $recipients, 'cc' => $cc, 'bcc' => $bcc]);
            $this->logger->info($exception->getTraceAsString(), ['recipients' => $recipients, 'cc' => $cc, 'bcc' => $bcc]);
        }

        return false;
    }
}