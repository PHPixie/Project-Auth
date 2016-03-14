<?php
namespace Project\App;

class ORMWrappers extends \PHPixie\ORM\Wrappers\Implementation
{
    protected $databaseEntities = array('user');
    protected $databaseRepositories = array('user');

    public function userEntity($entity)
    {
        return new ORM\User\Entity($entity);
    }

    public function userRepository($repository)
    {
        return new ORM\User\Repository($repository);
    }
}