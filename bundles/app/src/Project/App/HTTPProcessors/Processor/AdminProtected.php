<?php

namespace Project\App\HTTPProcessors\Processor;

use PHPixie\HTTP\Request;
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

    /**
     * Only process the request if the user is an admin.
     * Otherwise redirect to the admin login page.
     * @param Request $request
     * @return mixed
     */
    public function process($request)
    {
        $this->admin = $this->loggedAdmin();

        if($this->admin === null) {
            return $this->adminLoginRedirect();
        }

        return parent::process($request);
    }
}