<?php

namespace Project;

use Project\App\Auth;

/**
 * Default application bundle
 */
class App extends \PHPixie\DefaultBundle
{
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
     * @return Auth
     */
    public function auth()
    {
        return $this->builder->auth();
    }
}