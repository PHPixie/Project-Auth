<?php

return array(
    'type'      => 'group',
    'resolvers' => array(

        // a prefixed group for /admin/ routes
        'admin' => array(
            'type' => 'prefix',
            'path' => 'admin',
            'defaults' => array(
                'processor' => 'admin',
            ),
            'resolver' => array(
                'type' => 'group',
                'resolvers' => array(

                    'action' => array(
                        'type'     => 'pattern',
                        'path'     => '/<adminProcessor>/<action>'
                    ),

                    'processor' => array(
                        'type'     => 'pattern',
                        'path'     => '(/<adminProcessor>)',
                        'defaults' => array(
                            'adminProcessor' => 'dashboard',
                            'action'    => 'default'
                        )
                    ),
                )
            )
        ),

        'action' => array(
            'type'     => 'pattern',
            'path'     => '<processor>/<action>'
        ),

        'processor' => array(
            'type'     => 'pattern',
            'path'     => '(<processor>)',
            'defaults' => array(
                'processor' => 'dashboard',
                'action'    => 'default'
            )
        ),
        
    )
);
