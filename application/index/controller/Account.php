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
    public function addView()
    {
        //获取角色
        $roles = (new \app\index\model\Role())->where(["is_on" => 0])->field("id,name")->select();
        $this->assign([
            "token" => $this->buildToken(),
            "role" => $roles

        ]);
        return view("addView");
    }

    public function add()
    {
        $rule = [
            ["account", "require", "请填写帐号"],
            ["role", "require", "请选择角色"],
            ["passwd","require","请填写密码"]
        ];
        $validate = new Validate($rule);
        $data = $this->request->post();
        if (!$validate->check($data)) {
            $this->msg($validate->getError(), "添加帐号", "error");
        }
        $data["passwd"]=md5($data["passwd"]);
        if (!\app\index\model\Account::create($data)) {
            $this->msg("添加失败请检查网络", "添加帐号", "error");
        }
        $this->successSessionMsg("success","添加角色成功");

    }
}