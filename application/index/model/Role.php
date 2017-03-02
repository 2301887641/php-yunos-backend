<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/15
 * Time: 18:22
 */
namespace app\index\model;
use think\Model;
use think\Request;

class Role extends Model
{
    /**
     * 查询所有角色
     * @param $row
     * @param $page
     * @return mixed
     */
    public function getAll($draw,$rows,$page)
    {
        $search=Request::instance()->get("search.value");
        $where=[];
        if(!empty($search)){
            $where["name"]=["like","%$search%"];
        }
        $limit=$rows*$page;
        $count=$this->count();
        $instance=$this->limit($limit,$rows)->where($where)->order("id","desc")->select();
        array_walk($instance,[$this,"formatter_data"]);
        return [
            "draw"=>$draw,
            "recordsTotal"=>$count,
            "recordsFiltered"=>$count,
            "data"=>$instance
        ];
    }

    /**
     * 格式化数据
     * @param $v
     * @param $k
     */
    public function formatter_data(&$v,$k)
    {
        if($v["create_time"]){
            $v["create_time"]=date("Y-m-d",$v["create_time"]);
        }

    }











}