<?php

namespace Wouterds\IkHaat\Application;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;
use Wouterds\IkHaat\Application\Http\ServiceProvider as HttpServiceProvider;
use Wouterds\IkHaat\Infrastructure\View\ServiceProvider as ViewServiceProvider;

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

        $container->addServiceProvider(HttpServiceProvider::class);
        $container->addServiceProvider(ViewServiceProvider::class);

        return $container;
    }
}
