<?php
/**
 * 角色控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/10
 * Time: 18:28
 */
namespace app\index\controller;

use app\index\model\Privilege;
use think\Session;
use think\Validate;

class Role extends Base
{
    /**
     * 角色列表页展示
     * @return mixed
     */
    public function index()
    {
        $data = \app\index\model\Role::where(1)->paginate(10);
        $this->assign([
            "data" => $data
        ]);
        return $this->fetch();
    }

    /**
     * 添加角色页面展示
     * @return mixed
     */
    public function addView()
    {
        $privilege = new \app\index\model\Privilege();
        $helper = new \app\common\controller\Helper();
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
     * 添加角色
     */
    public function add()
    {
        $rule = [
            ["privilege_list", "require", "请选择权限"],
            ["name", "require|unique:Role", "请输入角色名称|角色名称重复,请重写"]
        ];
        $validate = new Validate($rule);
        $data = $this->request->post();
        if (!$validate->check($data)) {
            $this->msg($validate->getError(), "添加角色", "error");
        }
        $data["privilege_list"] = implode(",", $data["privilege_list"]);
        if (!\app\index\model\Role::create($data)) {
            $this->msg("添加失败", "添加角色", "error");
        }
        $this->successSessionMsg("添加角色成功");
    }

    /**
     * 修改页面展示
     */
    public function saveView()
    {
        $id = $this->request->post("id");
        $privilege = new \app\index\model\Privilege();
        $helper = new \app\common\controller\Helper();
        $data = $privilege->field("id,name,parent_id")->select();
        $rdata = (new \app\index\model\Role)->where(["id" => $id])->find();
        //使用树型结构展示上级权限
        $treeArr = $helper->get_tree($data);
        $this->assign([
            "treeArr" => $treeArr,
            "token" => $this->buildToken(),
            "data" => $rdata
        ]);
        return view("saveView");
    }

    /**
     * 角色修改
     */
    public function save()
    {
        $rule = [
            ["privilege_list", "require", "请选择权限"],
            ["name", "require|unique:Role", "请输入角色名称|角色名称重复,请重写"]
        ];
        $validate = new Validate($rule);
        $data = $this->request->post();
        if (!$validate->check($data)) {
            $this->msg($validate->getError(), "修改角色", "error");
        }
        $data["privilege_list"] = implode(",", $data["privilege_list"]);
        if (!\app\index\model\Role::update($data)) {
            $this->msg("修改失败", "修改角色", "error");
        }
        $this->successSessionMsg("修改角色成功");
    }

    /**
     * 删除操作
     */
    public function del()
    {
        $id = $this->request->post("id");
        if(!\app\index\model\Role::destroy($id)){
            $this->msg("删除失败", "删除操作","error");
        }
        $this->successSessionMsg("删除成功");
    }
}