<?php

namespace Project\App\ORM\User;

/**
 * User entity with support for Login auth
 */
class User extends \PHPixie\AuthORM\Repositories\Type\Login\User
{
    /**
     * @return string
     */
    public function passwordHash()
    {
        return $this->passwordHash;
    }
}