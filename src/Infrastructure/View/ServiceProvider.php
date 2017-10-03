<?php

namespace Wouterds\IkHaat\Infrastructure\View;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig_Loader_Filesystem;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Twig::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->container->share(Twig::class, function () {
            $loader = new Twig_Loader_Filesystem(APP_DIR . '/resources/views');
            return new Twig($loader);
        });
    }
}
