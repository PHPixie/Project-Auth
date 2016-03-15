<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;
use PHPixie\Template;
use Project\App\Builder;
use Project\App\ORM\User\User;

class Dashboard extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @param Builder $builder
     */

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function defaultAction(Request $request)
    {
        $components = $this->builder->components();

        /** @var User $user */
        $user = $components->auth()->domain()->user();

        return $components->template()->get('app:dashboard', array(
            'user' => $user
        ));
    }
}