<?php

namespace Project\App;

class HTTPProcessor extends \PHPixie\DefaultBundle\Processor\HTTP\Builder
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Constructor
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function process($request)
    {
        $firewall = $this->builder->firewall();
        if($firewall->requireLogin($request)) {
            return $this->builder->frameworkBuilder()->http()->redirectResponse('app.loging');
        }

        return parent::process($request);
    }

    /**
     * Build 'greet' processor
     * @return HTTPProcessors\Auth
     */
    protected function buildAuthProcessor()
    {

        return new HTTPProcessors\Auth(
            $this->builder
        );
    }

    /**
     * Build 'dashboard' processor
     * @return HTTPProcessors\Greet
     */
    protected function buildDashboardProcessor()
    {
        return new HTTPProcessors\Dashboard(
            $this->builder
        );
    }

    /**
     * Build 'frontpage' processor
     * @return HTTPProcessors\Greet
     */
    protected function buildFrontpageProcessor()
    {
        return new HTTPProcessors\Frontpage(
            $this->builder
        );
    }
}