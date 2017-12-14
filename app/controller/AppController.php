<?php

namespace Sharminshanta\Web\Accounts\Controller;

use Psr\Container\ContainerInterface;
use Monolog\Logger;

/**
 * Class AppController
 * @package Previewtechs\Web\CareerWebsite\Controller
 */
class AppController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \Memcached
     */
    protected $memcache;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var \Slim\Views\Twig
     */
    protected $view;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var
     */
    public $homeUrl;

    /**
     * AppController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $home = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
        $this->homeUrl = rtrim($home, '/');
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->container->get('logger');
    }

    /**
     * @return \Slim\Views\Twig
     */
    public function getView()
    {
        return $this->container->get('view');
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->container->get('settings');
    }

    /**
     * @return \Slim\Flash\Messages
     */
    public function getFlash()
    {
        return $this->container->get('flash');
    }

    /**
     * @return Email;
     */
    public function getEmail()
    {
        return $this->container->get('email');
    }
}