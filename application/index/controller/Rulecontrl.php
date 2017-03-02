<?php
/**
 * 角色控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/10
 * Time: 18:28
 */
namespace app\index\controller;

class Rulecontrl extends Base
{
    /**
     * 角色列表页展示
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 添加页面展示
     * @return mixed
     */
    public function add()
    {
        return view();
    }

    /**
     * ajax获取全部角色数据
     * @return mixed
     */
    public function getAll()
    {
        $draw = $this->Rinstance->get("draw");
        $rows = $this->Rinstance->get("length");
        $page = $this->Rinstance->get("start");
        return (new \app\index\model\Role)->getAll($draw, $rows, $page);
    }




}