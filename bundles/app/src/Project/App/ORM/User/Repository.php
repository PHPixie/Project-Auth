<?php

namespace Project\App\ORM\User;

class Repository extends \PHPixie\AuthORM\Repositories\Type\Login
{
    protected function loginFields()
    {
        return array('username', 'email');
    }
}