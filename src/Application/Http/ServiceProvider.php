<?php

namespace Wouterds\IkHaat\Application\Http;

use Jenssegers\Lean\SlimServiceProvider;

class ServiceProvider extends SlimServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        parent::register();

        $this->container->share('settings', function() {
            $settings = $this->defaultSettings;
            $settings['displayErrorDetails'] = true;

            return $settings;
        });
    }
}
