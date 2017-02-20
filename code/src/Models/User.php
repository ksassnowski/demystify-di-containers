<?php

namespace Container\Models;

use Container\Session\SessionStorage;

class User
{
    /**
     * @var SessionStorage
     */
    private $storage;

    /**
     * User constructor.
     *
     * @param SessionStorage $storage
     */
    public function __construct(SessionStorage $storage)
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
