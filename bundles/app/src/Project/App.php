<?php

namespace Project;

use Project\App\Auth;
use Project\App\Builder;

/**
 * Default application bundle
 */
class App extends \PHPixie\DefaultBundle
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Build bundle builder
     * @param \PHPixie\BundleFramework\Builder $frameworkBuilder
     * @return App\Builder
     */
    protected function buildBuilder($frameworkBuilder)
    {
        return new App\Builder($frameworkBuilder);
    }

    /**
     * Authorization helper
     * @return Auth
     */
    public function auth()
    {
        return $this->builder->auth();
    }
}