<?php

namespace Project\App;

/**
 * App bundle builder
 */
class Builder extends \PHPixie\DefaultBundle\Builder
{
    /**
     * Auth
     * @return Auth
     */
    public function auth()
    {
        return $this->instance('auth');
    }

    /**
     * Build Auth
     * @return Auth
     */
    protected function buildAuth()
    {
        return new Auth($this);
    }


    /**
     * Build Processor for HTTP requests
     * @return HTTPProcessor
     */
    protected function buildHttpProcessor()
    {
        return new HTTPProcessor($this);
    }

    /**
     * Build ORM Wrappers
     * @return ORMWrappers
     */
    protected function buildORMWrappers()
    {
        return new ORMWrappers($this);
    }

    /**
     * @return AuthRepositories
     */
    protected function buildAuthRepositories()
    {
        return new AuthRepositories(
            $this->components()->orm()
        );
    }

    /**
     * Get bundle root directory
     * @return string
     */
    protected function getRootDirectory()
    {
        return realpath(__DIR__.'/../../../');
    }

    /**
     * Get bundle name
     * @return string
     */
    public function bundleName()
    {
        return 'app';
    }
}