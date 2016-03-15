<?php

namespace Project\App\ORM\User;

/**
 * User repository with support for Login auth
 */
class UserRepository extends \PHPixie\AuthORM\Repositories\Type\Login
{
    /**
     * @return array Array of fields that can be used to login with
     */
    protected function loginFields()
    {
        return array('email');
    }
}