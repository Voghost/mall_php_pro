<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Users as UsersModel;

class User extends Controller
{
    public function page($page = null, $limit = null)
    {
        $query = $this->request->post();
        $where = array();

        if (array_key_exists("user_id", $query)) {
            $where[] = ["user_id", "=", $query["user_id"]];
        }

        $res = UsersModel::page($page, $limit)->where($where)->select();
        $count = UsersModel::where($where)->count();

        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => [
                    "page" => $page,
                    "total" => $count,
                    "content" => $res
                ]
            ]
        );
    }

    // 更新user状态
    public function updateState($id, $state)
    {
        if ($id != null && $state != null) {
            $user = UsersModel::where("user_id", $id)->find();
            if ($user== null) {
                return \json(['message' => '修改失败', "code" => 201, 'data' => null]);
            }
            $user->user_is_active = $state;
            $user->save();
            return \json(['message' => 'ok', "code" => 200, 'data' => $user]);
        } else {
            return \json(['message' => '参数错误', "code" => 201, 'data' => null]);
        }

    }

    public function getUserById()
    {
        $query = $this->request->post();
        $user = UsersModel::where("user_id", $query["user_id"])->findOrFail();
        return $user;
    }

}
