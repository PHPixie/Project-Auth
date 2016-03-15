<?php

namespace Project\App;

use PHPixie\Auth;
use PHPixie\HTTP\Request;

/**
 * Logic behind protecting certain URLs
 */
class Firewall
{
    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var array
     */
    protected $allowAnonymous = array(
        'frontpage',
        'auth'
    );

    /**
     * Firewall constructor.
     * @param Auth $auth
     */
    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    /**
     * Check if a particular request requires
     * the user to be redirected to login page
     * @param Request $request
     * @return bool
     */
    public function requireLogin($request)
    {
        $processor = $request->attributes()->get('processor');
        if(in_array($processor, $this->allowAnonymous)) {
            return false;
        }

        $user = $this->auth->domain()->user();
        return $user === null;
    }
}