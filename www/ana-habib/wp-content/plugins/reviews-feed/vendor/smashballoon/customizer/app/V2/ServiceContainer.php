<?php

namespace Smashballoon\Customizer\V2;

use Smashballoon\Stubs\Services\ServiceProvider;

class ServiceContainer extends ServiceProvider
{

    /**
     * @var ServiceProvider[]
     */
    public $services = [
        CustomizerBootstrapService::class
    ];

    public function register()
    {
        $container = Container::getInstance();

        foreach ($this->services as $service) {
            ($container->get($service))->register();
        }
    }
}