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

    /**
     * @param $entity
     * @return ORM\User\User
     */
    public function userEntity($entity)
    {
        return new ORM\User\User($entity);
    }

    /**
     * @param $repository
     * @return ORM\User\UserRepository
     */
    public function userRepository($repository)
    {
        return new ORM\User\UserRepository($repository);
    }

    /**
     * @param $entity
     * @return ORM\Admin\Admin
     */
    public function adminEntity($entity)
    {
        return new ORM\Admin\Admin($entity);
    }

    /**
     * @param $repository
     * @return ORM\Admin\AdminRepository
     */
    public function adminRepository($repository)
    {
        return new ORM\Admin\AdminRepository($repository);
    }
}