<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/23
 * Time: 9:57
 */
namespace  app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
class Base extends Controller
{
    //Request实例
    protected $Rinstance;
    /**
     * 初始化操作
     */
    public function _initialize()
    {
        parent::_initialize();
        //直接实例化request类方便后期调用
        $this->Rinstance = Request::instance();
        //插入表单时 检查是否传入token
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
            $this->msg("请不要重复提交","数据提交","error");
        }
    }
    /**
     * 统一的信息打印
     * @param $msg
     * @param $title
     * @param string $status
     */
    public function msg($msg,$title,$status="success")
    {
        if($status=="success"){
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
    public function delConfirm()
    {
        return view("public/confirm");
    }

}