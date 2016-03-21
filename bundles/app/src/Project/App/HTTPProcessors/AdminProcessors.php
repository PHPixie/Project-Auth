<?php

namespace Project\App\HTTPProcessors;

use Project\App\Builder;

class AdminProcessors extends \PHPixie\DefaultBundle\Processor\HTTP\Builder
{
    /**
     * @var Builder
     */
    protected $builder;

    protected $attributeName = 'adminProcessor';

    /**
     * Constructor
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    protected function buildDashboardProcessor()
    {
        return new Admin\Dashboard($this->builder);
    }

    protected function buildAuthProcessor()
    {
        return new Admin\Auth($this->builder);
    }
}