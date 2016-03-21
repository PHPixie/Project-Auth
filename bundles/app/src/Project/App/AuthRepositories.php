<?php

namespace Project\App;

use PHPixie\ORM;
use Project\App\ORM\Admin\AdminRepository;
use Project\App\ORM\User\UserRepository;

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

    /**
     * 'user' repository
     * @return UserRepository
     */
    protected function buildUserRepository()
    {
        return $this->orm->repository('user');
    }

    /**
     * 'admin' repository
     * @return AdminRepository
     */
    protected function buildAdminRepository()
    {
        return $this->orm->repository('admin');
    }
}