<?php

namespace app\index\controller;

use app\common\model\Users;
use app\common\model\Users as UsersModel;
use app\common\utils\CheckUser;
use app\common\utils\JwtUtil;
use app\common\utils\ResultUtil;
use think\App;
use think\Controller;
use think\Exception;

class User extends Controller
{
    private $userService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->userService = \think\facade\App::model("user", "service", true);
    }

    public function loginAuthen()
    {
        $username = $this->request->post("username");
        $password = $this->request->post("userpwd");
        $ticket = $this->request->post("ticket");
        $randStr = $this->request->post("randstr");
        $appId = $this->request->post("appid");

        if ($this->check($ticket, $randStr, $appId) == 1) {
            $result = $this->userService->login($username, $password);
            if ($result != null) {
                $jwtUtil = new JwtUtil();
                $jwtEncode = $jwtUtil->jwtEncode($result["user_id"]);
                $result["user_token"] = $jwtEncode;
                $result["user_last_login_time"] = date("Y-m-d H:i:s", time());;
                $result->save();

                $userInfo = [
                    "user_id" => $result["user_id"],
                    "user_name" => $result["user_name"],
                    "user_avatar" => $result["user_avatar"],
                    "user_phone" => $result["user_phone"],
                    "user_sex" => $result["user_sex"],
                    "user_age" => $result["user_age"],
                    "user_email" => $result["user_email"],
                ];

                $data = ["token" => $result["user_token"], "user_info" => $userInfo];
                return ResultUtil::OK($data);
//                return \json(["message" => "ok", "code" => 200, "data" => $data, "ok" => true]);
            } else {
                return ResultUtil::FAIL();
//                return \json(["message" => "验证失败", "code" => 201, "data" => null]);
            }
        }
        return ResultUtil::FAIL();
    }

    public function registerAuthen()
    {
        $username = $this->request->post("username");
        $password = $this->request->post("userpwd");
        $ticket = $this->request->post("ticket");
        $randStr = $this->request->post("randstr");
        $appId = $this->request->post("appid");


        if ($this->check($ticket, $randStr, $appId) == 1) {
            $user = new Users();
            $user["user_name"] = $username;
            $user["user_password"] = md5($password);
            $user->save();
//            if ($result != null) {
//                $jwtUtil = new JwtUtil();
//                $jwtEncode = $jwtUtil->jwtEncode($result["user_name"]);
//                $result["user_token"] = $jwtEncode;
//                $result->save();
//
//                $data = ["token" => $result["user_token"]];
//                return \json(["message" => "ok", "code" => 200, "data" => $data, "ok" => true]);
//            } else {
//                return \json(["message" => "验证失败", "code" => 201, "data" => null]);
//            }
            return 1;
        } else {
            return 0;
        }
    }


    public function updateUser()
    {
        $user = $this->checkUser();
        $map = $this->request->post();
        $this->userService->updateUser($user, $map);
        return json(["ok" => $user]);
    }

    public function getUserInfo()
    {
        $users = CheckUser::checkUser($this->request);

        $userInfo = [
            "user_id" => $users["user_id"],
            "user_name" => $users["user_name"],
            "user_avatar" => $users["user_avatar"],
            "user_phone" => $users["user_phone"],
            "user_sex" => $users["user_sex"],
            "user_age" => $users["user_age"],
            "user_email" => $users["user_email"],
        ];
        return ResultUtil::OK($users);
    }

    private function checkUser()
    {
        // 解密token
        $token = $this->request->header('Authorization');
        try {
            $jwtUtil = new JwtUtil();
            $res = $jwtUtil->jwtDecode($token);
        } catch (Exception $e) {
            json(["message" => ["meta" => ["msg" => "error: token无效=> $e", "code" => 403]]])->send();
            exit();
        }

        // 查询是否存在用户
        $userTemp = UsersModel::where("user_id", $res["message"])->find();
        if ($userTemp == null || $userTemp["user_id"] == null || $userTemp["user_is_active"] == false) {
            json(["message" => ["meta" => ["msg" => "error: 鉴权失败", "code" => 403]]])->send();
            exit();
        } else {
            return $userTemp;
        }
    }

    public function check($ticket, $randStr, $appid)
    {
        $url = "https://ssl.captcha.qq.com/ticket/verify";
        $params = array(
            "aid" => $appid,
            "AppSecretKey" => "0bbjok7FyHMKMQsg7LhuTTA**",
            "Ticket" => $ticket,
            "Randstr" => $randStr,
            "UserIP" => $_SERVER["REMOTE_ADDR"]
//            "UserIP" => "127.0.0.1"
        );
        $paramstring = http_build_query($params);
        $content = $this->userService->txcurl($url, $paramstring);

        $result = json_decode($content, true);
//        json($result)->send();
//        exit();
        if ($result) {
            if ($result['response'] == 1) {
                return 1;
            } else {
                json(($result['response'] . ":" . $result['err_msg']), 403)->send();
                exit();
            }
        } else {
            json(($result['response'] . ":" . $result['err_msg']), 403)->send();
            exit();
//            return ResultUtil::FAIL();
        }


//        $this->userService->login();

        echo $content;
    }

    public function changePassword($username)
    {
        $tempUser=CheckUser::checkUser($this->request);
        $userId=$tempUser->user_id;
        $query = $this->request->post();
        $password = md5($query["password"]);
        $user = UsersModel::where("user_id", $userId)->find();
        if($user->user_password == $password){
            $user["user_password"] = md5($query["newPassword"]);
            $user->save();
            ResultUtil::OK();
        }else {
            ResultUtil::FAIL();
        }

    }

}
