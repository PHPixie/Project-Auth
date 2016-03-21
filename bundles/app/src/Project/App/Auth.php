<?php

namespace Project\App;

use PHPixie\ORM;
use Project\App\ORM\Admin\Admin;
use PHPixie\AuthLogin\Providers\Password as PasswordProvider;

/**
 * Authorization helper
 */
class Auth
{
    /**
     * @var Builder
     */
    protected $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function userDomain()
    {
        return $this->builder->components()->auth()->domain();
    }

    public function adminDomain()
    {
        return $this->builder->components()->auth()->domain('admin');
    }

    public function addAdmin($username, $password)
    {
        /** @var PasswordProvider $passwordProvider */
        $passwordProvider = $this->adminDomain()->provider('password');

        /** @var Admin $admin */
        $admin = $this->builder->components()->orm()->createEntity('admin');
        $admin->username = $username;
        $admin->passwordHash = $passwordProvider->hash($password);
        $admin->save();
        return $admin;
    }
}