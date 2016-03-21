<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;
use Project\App\HTTPProcessors\Processor\UserProtected;

/**
 * User dashboard
 */
class Dashboard extends UserProtected
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function defaultAction(Request $request)
    {
        return $this->components->template()->get('app:user/dashboard', array(
            'user' => $this->user
        ));
    }
}