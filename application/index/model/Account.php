<?php
/**
 * Created by PhpStorm.
 * User: qiangbi
 * Date: 17-3-31
 * Time: 下午6:36
 */

namespace app\index\model;

use think\Model;
use think\Request;
use think\Session;
use think\Url;

class Account extends Model
{
    /**
     * init初始化操作
     */
    public static function init()
    {
        parent::init();
        //写入操作时 获取role_name
        Account::event('before_write', function ($account) {
            $account->role_name = (\app\index\model\Role::where("id", $account->role)->value("name"));
        });
    }

    /**
     * 检测用户登录时的帐号和密码
     * @param $user_arr
     * @return array
     */
    public function checkLogin($user_arr)
    {
        $user = self::get(["account" => $user_arr["account_name"]]);
        if (empty($user)) {
            return ["errno" => 1, "msg" => "没有此用户"];
        }

        if ($user->passwd != md5($user_arr["account_password"])) {
            return ["errno" => 1, "msg" => "帐号或密码错误"];
        }

        $this->getRoles($user->role);
        Session::set("id", $user->id);
        Session::set("user_name", $user->account);
        return ["errno" => 0, "route" => Url::build("index/index/index")];
    }

    /**
     * 获取当前角色的信息
     * @param $role_id
     */
    public function getRoles($role_id)
    {
        $role = Role::get($role_id);
        if (empty($role)) {
            exit (json_encode(["errno" => 1, "msg" => "当前用户没有任何权限,无法登录!"]));
        }
        $this->refreshPrivlege($role->getAttr("privilege_list"));
    }

    /**
     * 整理用户的所有权限
     * 需要整理 2样数据
     * 1.权限列表
     * 2.菜单列表
     * @param $privilegeList
     */
    public function refreshPrivlege($privilegeList)
    {
        //如果是系统管理员的话 直接将*放到session中
        if ($privilegeList == "*") {
            Session::set("privelege", "*");
            //将权限表中前两级的当作菜单取出来
            $plist = (new Privilege)->where(["parent_id" => 0])->field("id,name")->select();
            $this->getMenu($plist);
        } else {
            $where["id"] = ["in", $privilegeList];
            $plist = Privilege::where($where)->select();
            $plist_arr = collection($plist)->toArray();
            //session中生成菜单    //现在的问题是获取的数据中如何找出parent_id=0的。
            $this->getParent($plist_arr);
        }
    }

    /**
     * 遍历数据获取parent_id=0的
     * @param $plist
     */
    public function getParent($plist)
    {
        $parent = [];
        $pri = [];
        foreach ($plist as $pk => $pv) {
            if ($pv["parent_id"] == 0) {
                $parent[] = $pv;
            }
            if (strpos($pv["action_name"], ",")) {
                $pv_arr = explode(",", $pv["action_name"]);
                $pri[] = $pv["module_name"] . "/" . $pv["controller_name"] . "/".$pv_arr[0];
                $pri[] = $pv["module_name"] . "/" . $pv["controller_name"] ."/". $pv_arr[1];
                continue;
            }
            $pri[] = $pv["module_name"] . "/" . $pv["controller_name"] . "/" . $pv["action_name"];
        }
        //session中生成权限
        Session("privelege",$pri);
        $this->mapSub($plist, $parent);
    }

    /**
     * 超级管理员意外的用户分配菜单
     * @param $plist
     * @param $parent
     */
    public function mapSub($plist, $parent)
    {
        $sub = [];
        foreach ($plist as $pk => $pv) {
            foreach ($parent as $parentk => $parentv) {
                //这里注意在循环中 给当前循环的数组再次添加元素的技巧
                if ($pv["parent_id"] == $parentv["id"]) {
                    $parent[$parentk]["sub"][] = $pv;
                }
            }
        }
        Session::set("sub", $parent);
    }

    /**
     * 根据权限列表在session中放置菜单信息
     * 根据parent_id=0 的查询下级子节点
     * @param $plist
     */
    public function getMenu($plist)
    {
        foreach ($plist as $k => $v) {
            $temp = $v->getData();
            $temp["sub"] = Privilege::where(["parent_id" => $temp["id"]])->field("name,module_name,controller_name,action_name")->select();
            $arr[] = $temp;
        }
        Session::set("sub", $arr);
    }
}