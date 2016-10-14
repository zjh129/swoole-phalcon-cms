<?php
namespace MyApp\Controllers\Home;

class ErrorsController extends BaseController
{
    /**
     * 未经授权
     * @return [type] [description]
     */
    public function show401Action()
    {

    }
    /**
     * 404错误页面
     * @return [type] [description]
     */
    public function show404Action()
    {
        exit("404错误");
    }
    /**
     * 500错误页面
     * @return [type] [description]
     */
    public function show500Action()
    {

    }
}