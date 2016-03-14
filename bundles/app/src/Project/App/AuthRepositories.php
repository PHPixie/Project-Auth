<?php
namespace Project\App;

class AuthRepositories extends \PHPixie\Auth\Repositories\Registry\Builder
{
    protected $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    protected function buildUserRepository()
    {
        $orm = $this->builder->components()->orm();
        return $orm->repository('user');
    }
}