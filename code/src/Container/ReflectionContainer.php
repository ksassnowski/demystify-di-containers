<?php

namespace Container\Container;

use ReflectionClass;
use RuntimeException;
use ReflectionParameter;

/**
 * A DI Container supporting autowiring by using reflection to look
 * at the constructor parameters of the given class and then recursively
 * building all dependencies.
 */
class ReflectionContainer implements Container
{
    /**
     * @var array
     */
    private $bindings = [];

    /**
     * Registers a binding into the container.
     *
     * @param string          $abstract
     * @param callable|string $concrete
     */
    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * @param string $abstract
     *
     * @return object
     */
    public function get($abstract)
    {
        if ($this->has($abstract)) {
            $concrete = $this->bindings[$abstract];

            // If we have an explicit binding registered for the abstract string
            // and it is callable, we assume that we have been provided with a
            // factory method and simply call it and return its result.
            if (is_callable($concrete)) {
                return $concrete($this);
            }

            // If it is not callable we assume that we have been passed the fully
            // qualified name of a concrete class and simply try to resolve it instead.
            $abstract = $concrete;
        }

        $reflection = new ReflectionClass($abstract);

        // If we cannot instantiate the provided class that means we were
        // passed an interface that does not have an explicit binding. Since
        // there is no way for us to automatically resolve it we bail out.
        if (!$reflection->isInstantiable()) {
            throw new RuntimeException("Cannot instantiate [$abstract]");
        }

        $dependencies = $this->buildDependencies($reflection);

        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * Checks if a binding exists in the container.
     *
     * @param string $abstract
     *
     * @return bool
     */
    public function has($abstract)
    {
        return isset($this->bindings[$abstract]);
    }

    /**
     * Build all dependencies of a class by looking at the types of
     * its constructor parameters and building them recursively.
     *
     * @param ReflectionClass $reflection
     *
     * @return array
     */
    private function buildDependencies(ReflectionClass $reflection)
    {
        if (!$constructor = $reflection->getConstructor()) {
            return [];
        }

        $parameters = $constructor->getParameters();

        return array_map(function (ReflectionParameter $p) use ($reflection) {
            return $this->get($this->getType($p, $reflection));
        }, $parameters);
    }

    /**
     * Extract the type of a parameter and returns its string representation.
     * If the parameter has no type hint we cannot automatically resolve it
     * so we throw an exception.
     *
     * @param ReflectionParameter $parameter
     * @param ReflectionClass     $context
     *
     * @throws RuntimeException Thrown if the provided parameter doesn't have a type hint
     *
     * @return string
     */
    private function getType(ReflectionParameter $parameter, ReflectionClass $context)
    {
        if (!$type = $parameter->getType()) {
            throw new RuntimeException(
                "Cannot build [{$parameter->getName()}] while building [{$context->getName()}]"
            );
        }

        return (string) $type;
    }
}
