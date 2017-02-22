<?php

namespace Container\Container;

interface Container
{
    public function get($abstract);

    public function has($abstract);

    public function bind($abstract, $concrete);
}
