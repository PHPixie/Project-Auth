<?php

namespace Project\App\HTTPProcessors;

use PHPixie\BundleFramework\Components;
use PHPixie\HTTP\Responses\Response;
use Project\App\Builder;
use Project\App\ORM\Admin\Admin;
use Project\App\ORM\User\User;

/**
 * Base processor
 */
abstract class Processor extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var Components
     */
    protected $components;

    /**
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
        $this->components = $builder->components();
    }

    /**
     * @return User|null
     */
    protected function loggedUser()
    {
        return $this->builder->auth()->userDomain()->user();
    }

    /**
     * @return Admin|null
     */
    protected function loggedAdmin()
    {
        return $this->builder->auth()->adminDomain()->user();
    }

    /**
     * @return Response
     */
    protected function userLoginRedirect()
    {
        return $this->redirectResponse(
            'app.processor',
            array('processor' => 'auth')
        );
    }

    /**
     * @return Response
     */
    protected function adminLoginRedirect()
    {
        return $this->redirectResponse(
            'app.admin.processor',
            array('adminProcessor' => 'auth')
        );
    }

    /**
     * @return Response
     */
    protected function redirectResponse($route, $params = array())
    {
        return $this->builder->frameworkBuilder()->http()->redirectResponse(
            $route,
            $params
        );
    }
}