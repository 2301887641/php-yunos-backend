<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/23
 * Time: 9:57
 * 首页相关控制器
 */
namespace app\index\controller;
use app\home\controller\Base;
class Index extends Base
{
    /**
     * 首页html展示
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }
    
    public function index_show()
    {
        return $this->fetch();
    }
}
