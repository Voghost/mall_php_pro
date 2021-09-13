<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Category as CategoryModel;

class Category extends Controller
{
    // 获取cat
    public function getCategory($level, $pid)
    {
        if ($level != null && $pid != null) {
            $categories = CategoryModel::where("cat_pid", $pid)->where("cat_level", $level)->select();
            return \json(['message' => 'ok', "code" => 200, 'data' => $categories]);
        } else {
            return \json(['message' => '参数错误', "code" => 200, 'data' => null]);
        }
    }

    // 更新cat状态
    public function updateState($cid, $state)
    {
        if ($cid != null && $state != null) {
            $category = CategoryModel::where("cat_id", $cid)->find();
            if ($category == null) {
                return \json(['message' => '修改失败', "code" => 201, 'data' => null]);
            }
            $temp = ($state == 1);
            $category->cat_deleted = $temp;
            $category->save();
            return \json(['message' => 'ok', "code" => 200, 'data' => $category]);
        } else {
            return \json(['message' => '参数错误', "code" => 201, 'data' => null]);
        }

    }

    public function saveOrUpdate()
    {

        $query = $this->request->put();
        $count = 0;
        if (!array_key_exists("cat_id", $query) || $query["cat_id"] == "") {
            $category = new CategoryModel();
        } else {
            $category = CategoryModel::where("cat_id", $query["cat_id"])->find();
        }

        if (array_key_exists("cat_name", $query) && $query['cat_name'] != "") {
            $category->cat_name = $query['cat_name'];
            $count++;
        }
        if (array_key_exists("cat_pid", $query)) {
            $category->cat_pid = $query['cat_pid'];
            $count++;
        }
        if (array_key_exists("cat_level", $query)) {
            $category->cat_level = $query['cat_level'];
            $count++;
        }
        if (array_key_exists("cat_icon", $query)) {
            $category->cat_icon = $query['cat_icon'];
            $count++;
        }
        // 如果有数据修改或添加
        if ($count > 0) {
            $category->save();
        }
        return \json(['message' => 'ok', "code" => 200, 'data' => $category]);
    }
}
