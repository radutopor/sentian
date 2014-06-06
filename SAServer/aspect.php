<?php

use Aspect\DemoAspectKernel;

// include __DIR__ . '/vendor/autoload.php';
require __DIR__.'/bootstrap/autoload.php';

// Prevent an error about nesting level
ini_set('xdebug.max_nesting_level', 300);

// Initialize aspect container
$aspectKernel = DemoAspectKernel::getInstance();
$aspectKernel->init(array(
    'cacheDir'  => __DIR__.'/app/storage/cache/aspect/',
    'debug'     => true,
));