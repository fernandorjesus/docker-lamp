<?php

declare (strict_types=1);
namespace SmashBalloon\Reviews\Vendor\DI;

use SmashBalloon\Reviews\Vendor\Psr\Container\ContainerExceptionInterface;
/**
 * Exception for the Container.
 */
class DependencyException extends \Exception implements ContainerExceptionInterface
{
}
