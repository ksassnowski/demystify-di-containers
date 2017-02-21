<?php

namespace Container\Logging;

class DatabaseLogger implements Logger
{
    /**
     * @param $message
     */
    public function log($message)
    {
        echo "Logging '$message' to the database".PHP_EOL;
    }
}
