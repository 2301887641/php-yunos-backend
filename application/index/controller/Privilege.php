<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/10
 * Time: 18:30
 */
namespace app\index\controller;

use think\Session;
use think\Validate;

class Privilege extends Base
{
    /**
     * 权限首页展示
     * @return mixed
     */
    public function index()
    {

        $data = \app\index\model\Privilege::all();
        $helper = new \app\common\controller\Helper();
        //使用树型结构展示上级权限
        $treeArr = $helper->get_tree($data);
        $this->assign([
            "data" => $treeArr
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
     * 权限添加数据
     */
    public function add()
    {
        $this->checkToken();
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
        Session::flash("success", "添加权限成功!!");
        $this->msg("添加成功", "添加权限");
    }

    /**
     * 权限修改展示页面
     * @return \think\response\View
     */
    public function saveView()
    {
        $id = $this->request->post("id");
        $privilege = new \app\index\model\Privilege();
        $helper = new \app\common\controller\Helper();
        $data = $privilege->field("id,name,parent_id")->where(["id" => ["neq", $id]])->select();
        $one = $privilege->where(["id" => $id])->find();
        //使用树型结构展示上级权限
        $treeArr = $helper->get_tree($data);
        $this->assign([
            "treeArr" => $treeArr,
            "token" => $this->buildToken(),
            "data" => $one
        ]);
        return view("saveView");
    }

    /**
     * 修改数据操作
     */
    public function save()
    {
        $this->checkToken();
        $rule = [
            ["name", "require|unique:Privilege", "请填写权限名称|权限名称已经存在"],
            ["module_name", "require", "请填写模块名称"],
            ["controller_name", "require", "请填写控制器名称"],
            ["action_name", "require", "请填写方法名称"],
        ];
        $validate = new Validate($rule);
        $request = $this->Rinstance->post();
        if (!$validate->check($request)) {
            $this->msg($validate->getError(), "修改信息", "error");
        }
        if (!\app\index\model\Privilege::update($request)) {
            $this->msg("修改失败", "修改信息", "error");
        }
        Session::flash("success", "修改权限成功!!");
        $this->msg("修改成功", "修改信息");
    }

    /**
     * 删除操作
     */
    public function del()
    {
        $id = $this->request->post("id");
        if(!\app\index\model\Privilege::destroy($id)){
            $this->msg("删除失败", "删除操作","error");
        }
        $this->msg("删除成功", "删除操作");
    }
}