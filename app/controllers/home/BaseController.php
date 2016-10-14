<?php

namespace MyApp\Controllers\Home;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    public function afterExecuteRoute()
    {
        //设置视图路径
        $this->view->setViewsDir($this->view->getViewsDir() . 'home/');
    }
}