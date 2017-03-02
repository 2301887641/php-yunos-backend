<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/10
 * Time: 18:30
 */
namespace app\index;
use app\home\Base;
use think\Request;

class Privilege extends Base
{
    public function add()
    {
        $request=Request::instance();
        if($request->isPost()){




        }
        return $this->fetch();
    }












}