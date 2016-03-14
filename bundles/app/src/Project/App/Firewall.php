<?php

namespace Project\App;

class Firewall
{
    protected $auth;

    protected $allowAnonymous = array(
        'frontpage',
        'auth'
    );

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

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