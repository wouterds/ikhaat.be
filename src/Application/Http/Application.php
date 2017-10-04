<?php

namespace Wouterds\KabouterWesley\Application\Http;

use Slim\App;
use Wouterds\KabouterWesley\Application\Container;

class Application extends App
{
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
