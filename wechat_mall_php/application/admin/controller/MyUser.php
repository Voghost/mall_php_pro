<?php

namespace app\admin\controller;

use app\common\utils\JwtUtil;
use app\common\utils\PasswordHash;
use think\Controller;
use app\admin\model\MyUser as MyUserModel;
use think\response\Json;
use think\validate\ValidateRule;

class MyUser extends Controller
{

    /**
     * 用户登陆
     */
    public function login()
    {
        $username = $this->request->param("username");
        $password = $this->request->param("password");

        $myUser = MyUserModel::where("user_name", $username)->find();
        $passwordHash = new PasswordHash(8, true);
        if ($passwordHash->CheckPassword($password, $myUser->user_password)) {
            $jwtUtil = new JwtUtil();
            $jwtEncode = $jwtUtil->jwtEncode($username);
            $myUser->user_token = $jwtEncode;
            $myUser->save();
//            return \json(["message" => "ok", "code" => 200, "data" => $myUser]);

            $data = ["token" => $myUser->user_token];
            return \json(["message" => "ok", "code" => 200, "data" => $data, "ok" => true]);
        } else {
            return \json(["message" => "验证失败", "code" => 201, "data" => null]);
        }
    }

    /**
     * 用户注册
     * @return Json
     */
    public function register()
    {
        $username = $this->request->param("username");
        $password = $this->request->param("password");
        if ($username == null || $password == null || $username == "" || $password == "") {
            return json(["message" => "缺少用户名或密码", "code" => 201, "data" => null]);
        }

        $temp = MyUserModel::where("user_name", $username)->find();
        if ($temp != null) {
            return json(["message" => "用户名已存在", "code" => 201, "data" => null]);
        }


        // 加密密码
        $hashUtil = new PasswordHash(8, true);
        $hashedPassword = $hashUtil->HashPassword($password);

        $myUser = new MyUserModel();
        $myUser->save([
            'user_name' => $username,
            'user_password' => $hashedPassword
        ]);

        return json(["message" => "注册成功", "code" => 200, "data" => null]);
    }

    /**
     * 获取某个用户信息
     * @return Json
     */
    public function info()
    {
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, token");
        $token = $this->request->header("Authorization");
//        $token = $this->request->header("token");
        $jwtUtil = new JwtUtil();
        $username = $jwtUtil->jwtDecode($token)["message"];
        $myUser = MyUserModel::with("roles")->where("user_name", $username)->find();
        $rolesTemp = $myUser->roles;


        $rolesList = array();
        foreach ($rolesTemp as $rol) {
            array_push($rolesList, $rol["roles_name"]);
        }

        $res = ["name" => $myUser->user_name, "userId" => $myUser->user_id, "roles" => $rolesList];


        return json(["message" => "ok", "code" => 200, "data" => $res, "ok" => true]);
    }

    /**
     * 所有  用户包含roles
     * @return Json
     */
    public function all()
    {
        $userList = MyUserModel::with("roles")->all();
        $userList->hidden(["roles" => ["pivot"]])->toArray();
        return json($userList);
    }

    /**
     * 登出
     * @return Json
     */
    public function logout()
    {
        // 查询用户并消除token
//        $token = $this->request->header("token");
        $token = $this->request->header("Authorization");
        $jwtUtil = new JwtUtil();
        $username = $jwtUtil->jwtDecode($token)["message"];
        $myUser = MyUserModel::with("roles")->where("user_name", $username)->find();
        $myUser->user_token = "";
        $myUser->save();
        return json(["message" => "ok", "code" => 200, "data" => null]);
    }


}
