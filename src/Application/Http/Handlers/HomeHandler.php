<?php

namespace Wouterds\IkHaat\Application\Http\Handlers;

use Slim\Http\Request;
use Slim\Http\Response;
use Wouterds\IkHaat\Infrastructure\View\Twig;

class HomeHandler
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $contents = $this->twig->render('home.html.twig');
        $response->getBody()->write($contents);

        return $response;
    }
}
