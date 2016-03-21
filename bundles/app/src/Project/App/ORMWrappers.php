<?php

namespace Project\App;

/**
 * ORM Wrapper registry
 */
class ORMWrappers extends \PHPixie\ORM\Wrappers\Implementation
{
    protected $databaseEntities = array(
        'user',
        'admin'
    );

    protected $databaseRepositories = array(
        'user',
        'admin'
    );

    public function userEntity($entity)
    {
        return new ORM\User\User($entity);
    }

    public function userRepository($repository)
    {
        return new ORM\User\UserRepository($repository);
    }

    public function adminEntity($entity)
    {
        return new ORM\Admin\Admin($entity);
    }

    public function adminRepository($repository)
    {
        return new ORM\Admin\AdminRepository($repository);
    }
}