<?php

namespace Wouterds\KabouterWesley\Application\Http\Handlers;

use Slim\Http\Request;
use Slim\Http\Response;
use Wouterds\KabouterWesley\Infrastructure\View\Twig;

abstract class ViewHandler implements View
{
    /**
     * @var Twig
     */
    protected $renderer;

    /**
     * ViewHandler constructor
     *
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->renderer = $twig;
    }

    /**
     * @param Response $response
     * @param array $data
     * @return Response
     */
    public function render(Response $response, array $data = []): Response
    {
        // Render template to response
        return $this->renderer->renderWithResponse($response, $this->getTemplate(), $data);
    }

    /**
     * Home request handler
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        return $this->render($response);
    }
}
