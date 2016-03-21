<?php

require_once(__DIR__.'/vendor/autoload.php');

$framework = new Project\Framework();
$framework->registerDebugHandlers();

//Create a new admin
/** @var \Project\App $appBundle */
$appBundle = $framework->builder()->components()->bundles()->get('app');
$appBundle->auth()->addAdmin($argv[1], $argv[2]);
