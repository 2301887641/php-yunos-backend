<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/10
 * Time: 18:30
 */
namespace app\index\controller;

use think\Validate;
use think\Db;

class Privilege extends Base
{
    /**
     * 权限首页展示
     * @return mixed
     */
    public function index()
    {
        //获取name进行查询
        $name = $this->Rinstance->get("name");
        $where = [];
        if (!empty($name)) {
            $where["name"] = $name;
        }
        $data = \app\index\model\Privilege::where($where)->paginate(5);
        $this->assign([
            "data" => $data
        ]);
        return $this->fetch();
    }

    /**
     * 权限添加页面
     * @return \think\response\View
     */
    public function addView()
    {
        $privilege = new \app\index\model\Privilege();
        $helper = new \app\common\Helper();
        $data = $privilege->field("id,name,parent_id")->select();
        //使用树型结构展示上级权限
        $treeArr = $helper->get_tree($data);
        $this->assign([
            "treeArr" => $treeArr,
            "token" => $this->buildToken(),
        ]);
        return view("addView");
    }

    /**
     * 权限添加数据
     */
    public function add()
    {
        $rule = [
            ["name", "require|unique:Privilege", "请填写权限名称|权限名称已经存在"],
            ["module_name", "require", "请填写模块名称"],
            ["controller_name", "require", "请填写控制器名称"],
            ["action_name", "require", "请填写方法名称"],
        ];
        $validate = new Validate($rule);
        $request = $this->Rinstance->post();
        if (!$validate->check($request)) {
            $this->msg($validate->getError(), "添加信息", "error");
        }
        $privilege = \app\index\model\Privilege::create($request);
        if (!$privilege->id) {
            $this->msg("添加失败", "添加权限", "error");
        }
        $this->msg("添加成功", "添加权限");
    }

}