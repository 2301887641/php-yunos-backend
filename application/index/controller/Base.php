<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/23
 * Time: 9:57
 */
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Session;

class Base extends Controller
{
    //Request实例
    protected $request;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        //直接实例化request类方便后期调用
        $this->request = $request;

    }

    /**
     * 提示权限不足信息
     * @return \think\response\View
     */
    public function permissionDeny()
    {
        return view("common@Helper/error");
    }

    /**
     * 验证token
     * @return array
     */
    public function checkToken()
    {
        $token = Session::get("token");
        $getToken = $this->request->post("token");
        if ($token != $getToken) {
            $this->msg("请不要重复提交", "数据提交", "error");
        }
    }

    /**
     * 统一的信息打印
     * @param $msg
     * @param $title
     * @param string $status
     */
    public function msg($msg='', $title='', $status = "success")
    {
        if ($status == "success") {
            $this->deleteToken();
        }
        exit(json_encode([
            "status" => $status,
            "msg" => $msg,
            "title" => $title
        ]));
    }

    /**
     * 删除token
     */
    public function deleteToken()
    {
        Session::delete("token");
    }

    /**
     * 生成token
     * @return string
     */
    public function buildToken()
    {
        $md5 = md5(md5(time() . chr(rand(65, 90)) . rand(1, 1000)) . rand(1, 1000));
        Session::set("token", $md5);
        return $md5;
    }

    /**
     * 统一删除提示操作 并将id assign到页面
     * @return \think\response\View
     */
    public function delConfirm()
    {
        $id = $this->request->post("id");
        return view("public/confirm",["id"=>$id]);//这里如何将id assign出去
    }

    /**
     * 成功
     * @param $name
     * @param $value
     */
    public function successSessionMsg($value)
    {
        Session::flash("success",$value);
        $this->msg();
    }

}