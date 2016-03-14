<?php

return array(
    'type'      => 'group',
    'resolvers' => array(

        'frontpage' => array('path' => '', 'defaults' => array(
            'processor' => 'frontpage',
            'action' => 'default'
        )),

        'dashboard' => array('path' => 'dashboard', 'defaults' => array(
            'processor' => 'dashboard',
            'action' => 'default'
        )),

        'login' => array('path' => 'login', 'defaults' => array(
            'processor' => 'auth',
            'action' => 'default'
        )),

        'logout' => array('path' => 'logout', 'defaults' => array(
            'processor' => 'auth',
            'action' => 'logout'
        )),

        'default' => array(
            'type'     => 'pattern',
            'path'     => '(<processor>(/<action>))',
            'defaults' => array(
                'processor' => 'login',
                'action'    => 'default'
            )
        )
        
    )
);
