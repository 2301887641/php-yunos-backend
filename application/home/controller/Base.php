<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/23
 * Time: 9:57
 */
namespace  app\home\controller;
use think\Controller;
use think\Request;
use think\Url;
class Base extends Controller
{
    //获取Request对象
    public $r;
    /**
     * 前置操作
     */
    public function _initialize()
    {
        //获取Request对象实例
        $this->r=Request::instance();
        //检查session
        if(!$this->r->session("user_name")){
            //跳转到登陆页面
//            $this->redirect(Url::build("login/login/login"));
        }
        parent::_initialize();
    }






}