<?php

namespace app\admin\controller;

use think\App;
use think\Controller;
use app\common\model\MyUser as MyUsersModel;

class Admin extends Controller
{
    private $adminService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->adminService = \think\facade\App::model("admin", "service", true);
    }

    public function page($page = null, $limit = null)
    {
        $query = $this->request->post();
        $where = array();

        if (array_key_exists("user_id", $query)) {
            $where[] = ["user_id", "=", $query["user_id"]];
        }

        $res = MyUsersModel::page($page, $limit)->where($where)->select();
        $count = MyUsersModel::where($where)->count();

        $list = $this->adminService->adminList($res);

        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => [
                    "page" => $page,
                    "total" => $count,
                    "content" => $list
                ]
            ]
        );
    }

    public function saveAdmin()
    {
        $query = $this->request->post();
        $result = $this->adminService->addAdmin($query);
        if($result == 1) {
            return json(
                ["message" => "ok",
                    "code" => 200]
            );
        } else {
            return json(
                ["message" => "error",
                    "code" => 201]
            );
        }
    }
}
