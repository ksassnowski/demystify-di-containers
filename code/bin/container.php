<?php

require __DIR__.'/../vendor/autoload.php';

use Container\Models\User;
use Container\Session\PhpSessionStorage;

$storage = new PhpSessionStorage();
$user = new User($storage);

$user->setLanguage('de');
echo $user->getLanguage();
