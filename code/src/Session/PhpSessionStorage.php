<?php

namespace Container\Session;

use Container\Logging\DatabaseLogger;
use Container\Logging\Logger;

class PhpSessionStorage implements SessionStorage
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * PhpSessionStorage constructor.
     *
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        session_start();
        $this->logger = $logger;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed|void
     */
    public function set($key, $value)
    {
        $this->logger->log("Setting [$key] to [$value]");

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
