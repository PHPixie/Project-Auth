<?php

namespace Project\App\HTTPProcessors;

use Project\App\Builder;

/**
 * Builds processors in the 'app.admin' namespace
 */
class AdminProcessors extends \PHPixie\DefaultBundle\Processor\HTTP\Builder
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Specifies which request attribute will be used
     * to select a processor.
     * @var string
     */
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