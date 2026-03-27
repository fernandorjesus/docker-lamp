<?php

declare (strict_types=1);
namespace SmashBalloon\Reviews\Vendor\DI\Definition\Source;

use SmashBalloon\Reviews\Vendor\DI\Definition\ObjectDefinition;
use SmashBalloon\Reviews\Vendor\DI\Definition\ObjectDefinition\MethodInjection;
use SmashBalloon\Reviews\Vendor\DI\Definition\Reference;
/**
 * Reads DI class definitions using reflection.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class ReflectionBasedAutowiring implements DefinitionSource, Autowiring
{
    public function autowire(string $name, ObjectDefinition $definition = null)
    {
        $className = $definition ? $definition->getClassName() : $name;
        if (!\class_exists($className) && !\interface_exists($className)) {
            return $definition;
        }
        $definition = $definition ?: new ObjectDefinition($name);
        // Constructor
        $class = new \ReflectionClass($className);
        $constructor = $class->getConstructor();
        if ($constructor && $constructor->isPublic()) {
            $constructorInjection = MethodInjection::constructor($this->getParametersDefinition($constructor));
            $definition->completeConstructorInjection($constructorInjection);
        }
        return $definition;
    }
    public function getDefinition(string $name)
    {
        return $this->autowire($name);
    }
    /**
     * Autowiring cannot guess all existing definitions.
     */
    public function getDefinitions() : array
    {
        return [];
    }
    /**
     * Read the type-hinting from the parameters of the function.
     */
    private function getParametersDefinition(\ReflectionFunctionAbstract $constructor) : array
    {
        $parameters = [];
        foreach ($constructor->getParameters() as $index => $parameter) {
	        // Skip optional parameters
	        if ($parameter->isOptional()) {
		        continue;
	        }

	        if (version_compare(phpversion(), '8.0.0') >= 0) {
		        $parameterClass = $parameter->getType() && ! $parameter->getType()->isBuiltin() ? new \ReflectionClass($parameter->getType()->getName()) : null;
	        } else {
		        $parameterClass = $parameter->getClass();
	        }

	        if ($parameterClass) {
		        $parameters[$index] = new Reference($parameterClass->getName());
	        }
        }
        return $parameters;
    }
}
