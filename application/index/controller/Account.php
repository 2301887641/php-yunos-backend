<?php
/**
 * 账号管理
 * Created by PhpStorm.
 * User: qiangbi
 * Date: 17-3-10
 * Time: 下午6:34
 */
namespace app\index\controller;


class Account extends Base
{
    /**
     * 首页html展示
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 添加页面展示
     * @return \think\response\View
     */
    public function addView()
    {
        return view("addView");
    }


}