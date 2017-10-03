<?php

namespace Wouterds\IkHaat\Application\Http;

use Twig_Environment;
use Twig_Loader_Filesystem;

class Application {
    /**
     * @var Twig_Loader_Filesystem
     */
    private $loader;

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem(APP_DIR . '/resources/views');
        $this->twig = new Twig_Environment($this->loader);
    }

    public function run()
    {
        echo $this->twig->render('index.html.twig');
    }
}
