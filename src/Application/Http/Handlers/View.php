<?php

namespace Wouterds\KabouterWesley\Application\Http\Handlers;

use Slim\Http\Response;

interface View
{
    /**
     * @return string
     */
    public function getTemplate(): string;

    /**
     * @param Response $response
     * @param array $data
     * @return Response
     */
    public function render(Response $response, array $data = []): Response;
}
