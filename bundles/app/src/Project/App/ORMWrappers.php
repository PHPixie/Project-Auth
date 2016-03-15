<?php

namespace Project\App;

/**
 * ORM Wrapper registry
 */
class ORMWrappers extends \PHPixie\ORM\Wrappers\Implementation
{
    protected $databaseEntities = array('user');
    protected $databaseRepositories = array('user');

    public function userEntity($entity)
    {
        return new ORM\User\User($entity);
    }

    public function userRepository($repository)
    {
        return new ORM\User\UserRepository($repository);
    }
}