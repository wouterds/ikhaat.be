<?php

namespace Wouterds\IkHaat\Application\Http\Handlers;

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
