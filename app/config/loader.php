<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs([
    $config->application->controllersDir,
    $config->application->pluginsDir,
    $config->application->libraryDir,
    $config->application->modelsDir,
    $config->application->formsDir
])->register();

$loader->registerNamespaces(
        array(
                'MyApp\Controllers\Home' => __DIR__ . '/../controllers/home',
                'MyApp\Controllers\Admin' => __DIR__ . '/../controllers/admin'
        )
)->register();
