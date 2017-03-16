<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/23
 * Time: 9:57
 */
namespace  app\index\controller;
use think\Controller;
use think\Request;
class Base extends Controller
{
    //Request实例
    protected $Rinstance;
    /**
     * 初始化操作
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->Rinstance = Request::instance();
    }

    /**
     * 提示权限不足信息
     * @return \think\response\View
     */
    public function permissionDeny()
    {
        return view("common@Helper/error");
    }




}