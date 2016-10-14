<?php
namespace MyApp\Controllers\Home;

class IndexController extends BaseController
{
    public function indexAction()
    {
        //print_r(get_loaded_extensions());
        //phpinfo();
        //echo json_encode(['test'=>'很好','ss'=>'你说呢？','b'=>'谢谢你']);
        //$this->view->disable();
        //exit();
        echo "asds";
        echo '你好，世界！';
        //var_dump();
    }
    public function testAction()
    {
        echo "success";
    }
}