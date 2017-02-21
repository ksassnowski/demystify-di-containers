<?php

require __DIR__.'/../vendor/autoload.php';

use Container\Logging\DatabaseLogger;
use Container\Models\User;
use Container\Session\PhpSessionStorage;

$logger = new DatabaseLogger();
$storage = new PhpSessionStorage($logger);
$user = new User($storage);

/** @var User $user */
$user->setLanguage('de');
echo $user->getLanguage('de');
