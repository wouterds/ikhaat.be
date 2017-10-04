<?php

namespace Wouterds\KabouterWesley\Application;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;
use Wouterds\KabouterWesley\Application\Http\ServiceProvider as HttpServiceProvider;
use Wouterds\KabouterWesley\Infrastructure\View\ServiceProvider as ViewServiceProvider;

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
