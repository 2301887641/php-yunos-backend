<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/23
 * Time: 9:57
 * 首页相关控制器
 */
namespace app\index\controller;
use app\index\model\Role;
use think\Session;

class Index extends Base
{
    /**
     * 首页html展示
     * @return mixed
     */
    public function index()
    {
        $sub=Session::get("sub");
        $temp=Session::get("temp");
        return $this->fetch("index",["sub"=>$sub,"temp"=>$temp]);
    }
    
    public function index_show()
    {
        return $this->fetch();
    }
}
