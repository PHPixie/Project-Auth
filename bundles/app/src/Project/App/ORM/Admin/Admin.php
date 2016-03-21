<?php

namespace Project\App\ORM\Admin;

/**
 * Admin entity with support for Login auth
 */
class Admin extends \PHPixie\AuthORM\Repositories\Type\Login\User
{
    /**
     * @return string
     */
    public function passwordHash()
    {
        return $this->passwordHash;
    }
}