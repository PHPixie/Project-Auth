<?php

namespace Project\App;

use PHPixie\ORM;

/**
 * Registry of user repositories for Auth component
 */
class AuthRepositories extends \PHPixie\Auth\Repositories\Registry\Builder
{
    /**
     * @var ORM
     */
    protected $orm;

    public function __construct($orm)
    {
        $this->orm = $orm;
    }

    protected function buildUserRepository()
    {
        return $this->orm->repository('user');
    }
}