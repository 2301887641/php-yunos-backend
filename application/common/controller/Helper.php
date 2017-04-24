<?php
/**
 * 工具帮助类
 * Created by PhpStorm.
 * User: qiangbi
 * Date: 17-3-14
 * Time: 下午6:23
 */
namespace app\common\controller;

use think\view;
use think\Controller;
class Helper extends Controller
{
    /**
     * 组织权限为树型结构
     * @param $data
     * @param int $parent_id
     * @param int $level
     * @return array
     */
    public function get_tree($data, $parent_id = 0, $level = 0) {
        static $arr = array();
        foreach ($data as $d) {
            if ($d['parent_id'] == $parent_id) {
                $d['level'] = $level;
                $arr[] = $d;
                $this->get_tree($data, $d['id'], $level + 1);
            }
        }

        return $arr;
    }

    /**
     * 错误页面展示
     * @return string
     */
    public function errord()
    {
        return $this->fetch();
    }

}