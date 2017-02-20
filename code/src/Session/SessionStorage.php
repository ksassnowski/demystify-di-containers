<?php

namespace Container\Session;

interface SessionStorage
{
    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key);
}
