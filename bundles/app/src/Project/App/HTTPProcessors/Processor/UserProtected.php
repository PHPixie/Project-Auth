<?php

namespace Project\App\HTTPProcessors\Processor;

use PHPixie\HTTP\Request;
use Project\App\HTTPProcessors\Processor;
use Project\App\ORM\User\User;

/**
 * Base processor that allows only logged in users
 */
abstract class UserProtected extends Processor
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Only process the request if the user is logged in.
     * Otherwise redirect to the login page.
     * @param Request $request
     * @return mixed
     */
    public function process($request)
    {
        $this->user = $this->loggedUser();

        if($this->user === null) {
            return $this->userLoginRedirect();
        }

        return parent::process($request);
    }
}