<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;
use PHPixie\Template;

class Dashboard extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
{
    /**
     * @var \Project\App\Builder
     */
    protected $builder;
    protected $components;

    public function __construct($builder)
    {
        $this->builder = $builder;
        $this->components = $this->builder->components();
    }

    public function defaultAction(Request $request)
    {
        $user = $this->components->auth()->domain()->user();

        return $this->components->template()->get('app:dashboard', array(
            'user' => $user
        ));
    }
}