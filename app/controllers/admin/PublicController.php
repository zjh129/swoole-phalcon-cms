<?php
namespace MyApp\Controllers\Admin;

class PublicController extends BaseController
{
    /**
     * 登陆控制器
     */
    public function loginAction()
    {
        
    }
    /**
     * 验证码
     */
    public function captchaAction()
    {
        $acaptcha = new \MyApp\Library\XCaptcha;
        $acaptcha->entryCode();
        $this->view->disable();
    }
}