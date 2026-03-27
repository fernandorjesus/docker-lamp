<?php

namespace Smashballoon\Customizer\V2;

class Container
{
    public static $container;

    /**
     * @return \DI\Container
     */
    public static function getInstance()
    {
        if (self::$container === null) {
            self::$container = (new \SmashBalloon\Reviews\Vendor\DI\ContainerBuilder())->build();
        }
        return self::$container;
    }
}