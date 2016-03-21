<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;
use PHPixie\Template;

/**
 * Frontpage processor
 */
class Frontpage extends Processor
{
    public function defaultAction(Request $request)
    {
        return $this->components->template()->get('app:frontpage', array(
            'user' => $this->loggedUser()
        ));
    }
}