<?php

namespace Wouterds\IkHaat\Application\Http;


use Wouterds\IkHaat\Infrastructure\View\Twig;

class Application
{
    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function run()
    {
        echo $this->twig->render('index.html.twig');
    }
}
