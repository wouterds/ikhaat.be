<?php

namespace Wouterds\IkHaat\Application\Http;

use Slim\App;
use Wouterds\IkHaat\Application\Container;

class Application extends App
{
    /**
     * Application constructor
     */
    public function __construct()
    {
        parent::__construct(Container::load());

        $this->loadRoutes();
    }

    /**
     * Load routes
     */
    private function loadRoutes()
    {
        $app = $this;
        require __DIR__ . '/routes.php';
    }
}
