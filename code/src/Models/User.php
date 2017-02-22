<?php

namespace Container\Models;

use Container\Session\PhpSessionStorage;

class User
{
    /**
     * @var PhpSessionStorage
     */
    private $storage;

    /**
     * User constructor.
     *
     * @param PhpSessionStorage $storage
     */
    public function __construct(PhpSessionStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->storage->set('language', $language);
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->storage->get('language');
    }
}
