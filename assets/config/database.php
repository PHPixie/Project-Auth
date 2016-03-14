<?php
$root = realpath(__DIR__.'/../../');

return array(
    'default' => array(
        'driver' => 'pdo',
        'connection' => "sqlite:$root/database.sqlite"

        /* MySQL
        'connection' => 'mysql:host=localhost;dbname=databaseName',
        'user'       => 'databaseUser',
        'password'   => 'databasePassword'
        */
    )
);