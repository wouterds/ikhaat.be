<?php

namespace Wouterds\KabouterWesley\Application\Http\Handlers;

class HomeHandler extends ViewHandler
{
    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return 'home.html.twig';
    }
}
