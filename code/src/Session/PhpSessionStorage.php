<?php

namespace Container\Session;

class PhpSessionStorage implements SessionStorage
{
    /**
     * @var string
     */
    private $cookieName;

    /**
     * SessionStorage constructor.
     *
     * @param string $cookieName
     */
    public function __construct($cookieName = 'PHP_SESS_ID')
    {
        session_name($cookieName);
        session_start();

        $this->cookieName = $cookieName;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed|void
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $_SESSION[$key];
    }
}
