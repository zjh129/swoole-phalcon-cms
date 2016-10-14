<?php

return new \Phalcon\Config(array(
	'database' => array(
		'adapter'     => 'Mysql',
		'host'        => 'localhost',
		'username'    => 'root',
		'password'    => '',
		'dbname'      => 'test',
	),
	'application' => array(
		'controllersDir' => APP_PATH . '/app/controllers/',
		'modelsDir'      => APP_PATH . '/app/models/',
	    'formsDir'       => APP_PATH . '/app/forms/',
		'viewsDir'       => APP_PATH . '/app/views/',
		'pluginsDir'     => APP_PATH . '/app/plugins/',
		'libraryDir'     => APP_PATH . '/app/library/',
		'cacheDir'       => APP_PATH . '/app/cache/',
		'baseUri'        => '/',
	)
));
