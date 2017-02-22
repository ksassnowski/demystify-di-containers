<?php

require __DIR__.'/../vendor/autoload.php';

use Container\Models\User;
use Container\Logging\Logger;
use Container\Logging\DatabaseLogger;

$container = new \Container\Container\ReflectionContainer();

$container->bind(Logger::class, DatabaseLogger::class);

$user = $container->get(User::class);

/* @var User $user */
$user->setLanguage('de');
echo $user->getLanguage();
