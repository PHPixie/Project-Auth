<?php

namespace Project\App\ORM\Admin;

/**
 * Admin repository with support for Login auth
 */
class AdminRepository extends \PHPixie\AuthORM\Repositories\Type\Login
{
    /**
     * @return array Array of fields that can be used to login with
     */
    protected function loginFields()
    {
        return array('username');
    }
}