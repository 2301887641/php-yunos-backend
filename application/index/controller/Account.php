<?php
/**
 * 账号管理
 * Created by PhpStorm.
 * User: qiangbi
 * Date: 17-3-10
 * Time: 下午6:34
 */

namespace app\index\controller;


use think\Validate;

class Account extends Base
{
    /**
     * 首页html展示
     * @return mixed
     */
    public function index()
    {
        $account = $this->request->post("account");
        $where = [];
        if (!empty($account)) {
            $where["account"] = $account;
        }
        $data = \app\index\model\Account::where($where)->paginate(10);
        $this->assign([
            "data" => $data,
        ]);
        return $this->fetch();
    }

    /**
     * 添加页面展示
     * @return \think\response\View
     */
    public function addview()
    {
        //获取角色
        $roles = (new \app\index\model\Role())->where(["is_on" => 0])->field("id,name")->select();
        $this->assign([
            "token" => $this->buildToken(),
            "role" => $roles

        ]);
        return view("addView");
    }

    /**
     * 添加帐号
     */
    public function add()
    {
        $rule = [
            ["account", "require", "请填写帐号"],
            ["role", "require", "请选择角色"],
            ["passwd", "require", "请填写密码"]
        ];
        $validate = new Validate($rule);
        $data = $this->request->post();
        if (!$validate->check($data)) {
            $this->msg($validate->getError(), "添加帐号", "error");
        }
        $data["passwd"] = md5($data["passwd"]);
        if (!\app\index\model\Account::create($data)) {
            $this->msg("添加失败请检查网络", "添加帐号", "error");
        }
        $this->successSessionMsg("添加角色成功");
    }

    /**
     * 修改页面展示
     * @return \think\response\View
     */
    public function saveView()
    {
        $id = $this->request->post("id");
        $data = (new \app\index\model\Account())->where(["id" => $id])->find();
        //获取角色
        $roles = (new \app\index\model\Role())->where(["is_on" => 0])->field("id,name")->select();
        $this->assign([
            "token" => $this->buildToken(),
            "role" => $roles,
            "data" => $data
        ]);
        return view("saveView");
    }

    /**
     * 修改数据
     */
    public function save()
    {
        $rule = [
            ["account", "require", "请填写帐号"],
            ["role", "require", "请选择角色"],
        ];
        $validate = new Validate($rule);
        $data = $this->request->post();
        if (!$validate->check($data)) {
            $this->msg($validate->getError(), "添加帐号", "error");
        }
        //如果密码是空的话,默认不修改密码
        if (empty($data["passwd"])) {
            unset($data["passwd"]);
        } else {
            $data["passwd"] = md5($data["passwd"]);
        }
        if (!\app\index\model\Account::update($data)) {
            $this->msg("修改失败", "修改信息", "error");
        }
        $this->successSessionMsg("修改权限成功");
    }

    /**
     * 删除操作
     */
    public function del()
    {
        $id = $this->request->post("id");
        if ($id == 1) {
            $this->successSessionMsg("删除成功");
        }
        if (!\app\index\model\Account::destroy($id)) {
            $this->msg("删除失败", "删除操作", "error");
        }
        $this->successSessionMsg("删除成功");
    }
}