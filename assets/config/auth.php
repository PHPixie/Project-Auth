<?php

return array(
    'domains' => array(
        'default' => array(

            // using the 'user' repository from the 'app' bundle
            'repository' => 'app.user',
            'providers'  => array(

                // include session support
                'session' => array(
                    'type' => 'http.session'
                ),

                // include persistent cookies (remember me)
                'cookie' => array(
                    'type' => 'http.cookie',

                    // when a cookie is used to login
                    // persist login using session too
                    'persistProviders' => array('session'),

                    // token storage
                    'tokens' => array(
                        'storage' => array(
                            'type'            => 'database',
                            'table'           => 'tokens',
                            'defaultLifetime' => 3600*24*14 // two weeks
                        )
                    )
                ),

                // password login suport
                'password' => array(
                    'type' => 'login.password',

                    // remember the user in session
                    // note that we did not add 'cookies' to this array
                    // because we don't want every login to be persistent
                    'persistProviders' => array('session')
                )
            )
        )
    )
);