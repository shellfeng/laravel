<?php
/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/6/13
 * Time: 16:52
 */

namespace App\Http\Utils;


class Common
{
    /**
     * 所到子类
     * @param type $arr
     * @param type $id
     * @return type
     */
    function find_child(&$arr, $id) {
        $childs = array();
        foreach ($arr as $v) {
            if (isset($v['pid'])) {
                $pid = $v['pid'];
            } elseif (isset($v['parent_id'])) {
                $pid = $v['parent_id'];
            } elseif (isset($v['referre_id'])) {
                $pid = $v['referre_id'];
            }
            if ($pid == $id) {
                $childs[] = $v;
            }
        }
        return $childs;
    }

    /**
     * 找到给定父类的所有子类
     * @param type $rows
     * @param type $root_id
     * @return type
     */
    function build_tree($rows, $pid = 0) {
        $childs = find_child($rows, $pid);
        if (empty($childs)) {
            return null;
        }
        foreach ($childs as $k => $v) {
            if (isset($v['user_id'])) {
                $id = $v['user_id'];
            } else if (isset($v['id'])) {
                $id = $v['id'];
            }
            $rescurTree = build_tree($rows, $id);
            if (null != $rescurTree) {
                $childs[$k]['children'] = $rescurTree;
            }
        }
        return $childs;
    }
}