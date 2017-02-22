<?php

namespace Container\Container;

/**
 * An extremely basic implementation of a DI Container that takes
 * advantage of higher-order functions to register bindings.
 */
class SimpleContainer implements Container
{
    /**
     * @var array
     */
    private $bindings = [];

    /**
     * Registers a binding into the container.
     *
     * @param string   $abstract
     * @param callable $factory
     */
    public function bind($abstract, $factory)
    {
        $this->bindings[$abstract] = $factory;
    }

    /**
     * Build a class by invoking the registered factory function.
     *
     * @param string $abstract
     *
     * @return mixed
     */
    public function get($abstract)
    {
        // Note that we're passing in the container itself to the closure.
        // This allows us to recursively build all of our dependencies inside
        // the factory method by delegating back to the container.
        return $this->bindings[$abstract]($this);
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
}
