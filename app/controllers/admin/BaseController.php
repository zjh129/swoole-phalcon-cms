<?php

namespace MyApp\Controllers\Admin;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
	public function afterExecuteRoute()
	{
        //设置视图路径
		$this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
		$this->url->setBaseUri('/admin/');
	}
}
