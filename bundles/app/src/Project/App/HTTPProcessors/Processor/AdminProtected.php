<?php

namespace Project\App\HTTPProcessors\Processor;

use Project\App\HTTPProcessors\Processor;
use Project\App\ORM\Admin\Admin;

/**
 * Base processor that allows only admins
 */
abstract class AdminProtected extends Processor
{
    /**
     * @var Admin
     */
    protected $admin;

    public function process($request)
    {
        $this->admin = $this->loggedAdmin();

        if($this->admin === null) {
            return $this->adminLoginRedirect();
        }

        return parent::process($request);
    }
}