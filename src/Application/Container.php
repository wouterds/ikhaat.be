<?php

namespace Wouterds\IkHaat\Application;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;

class Container extends LeagueContainer
{
    /**
     * Initialize container
     *
     * @return Container
     */
    public static function load()
    {
        $container = new static();
        $container->delegate(new ReflectionContainer());

        return $container;
    }
}
