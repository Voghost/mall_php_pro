<?php

namespace app\index\controller;

use app\common\utils\ResultUtil;
use think\App;
use think\Controller;

class User extends Controller
{
    private $userService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->userService = \think\facade\App::model("user", "service", true);
    }

    public function login()
    {
        $username = $this->request->post("username");
        $password = $this->request->post("password");

        if ($username == "" || $password == "") {
            return ResultUtil::FAIL();
        } else {
            if ($this->userService->login($username, $password)) {
                echo "true";
            } else {
                echo "false";
            }

        }


//        $this->userService->login();

    }


    public function check()
    {

    }
}
