<?php

$router = new Phalcon\Mvc\Router(false);
//默认控制器
$router->setDefaultNamespace('MyApp\Controllers\Home');
$router->setDefaultController('Index');
$router->setDefaultAction('index');

$router->add('/:controller/:action/:params', [
	//'namespace' => 'MyApp\Controllers\Home',
	'controller' => 1,
	'action' => 2,
	'params' => 3,
]);

$router->add('/:controller', [
	//'namespace' => 'MyApp\Controllers\Home',
	'controller' => 1
]);

//后台访问地址
$router->add('/admin/:controller/:action/:params', [
	'namespace' => 'MyApp\Controllers\Admin',
	'controller' => 1,
	'action' => 2,
	'params' => 3,
]);

$router->add('/admin/:controller', [
	'namespace' => 'MyApp\Controllers\Admin',
	'controller' => 1
]);

//设置后台访问控制器地址
$router->add('/admin',[
	'namespace' => 'MyApp\Controllers\Admin',
	'controller' => 'Index',
	'action' => 'index',
]);

return $router;