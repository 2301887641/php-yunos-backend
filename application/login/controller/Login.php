<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/21
 * Time: 10:32
 */
namespace app\login\controller;
use think\Config;
use think\Controller;
use think\Request;
use think\Validate;

class Login extends Controller
{
    /**
     * 登陆页面展示
     * @return mixed
     */
    public function login()
    {
        return $this->fetch();
    }

    /**
     * 验证用户登陆
     */
    public function login_on()
    {
        //接收数据
        $post_data=Request::instance()->post();
        //定义验证规则
        $rules=[
            "account_name"=>"require",
            "account_password"=>"require",
            "captcha_moude"=>"require"
        ];
        $msg=[
            "account_name.require"=>"请输入用户名",
            "account_password.require"=>"请输入密码",
            "captcha_moude.require"=>"请输入验证码"
        ];
        //检查用户名和密码
        $validate=new Validate($rules,$msg);
        if(!$validate->check($post_data)){
            return(["state"=>"error","msg"=>$validate->getError()]);
        }
        //验证码
        if(!captcha_check($post_data["captcha_moude"])){
            //验证失败
            return(["state"=>"error","msg"=>"验证码错误"]);
        };


    }





}