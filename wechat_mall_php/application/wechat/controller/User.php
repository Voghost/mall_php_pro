<?php

namespace app\wechat\controller;


use app\common\utils\JwtUtil;
use think\Controller;
use app\common\model\Users as UsersModel;
use think\facade\App;

class User extends Controller
{
    private $userService;

    public function __construct(\think\App $app = null)
    {
        parent::__construct($app);
        $this->userService = App::model("user", "service", true);
    }

    public function wxlogin()
    {
        $code = $this->request->param("code");
        return $this->userService->wxLogin($code);
    }


    public function test()
    {
        return $this->userService->show();
    }
}