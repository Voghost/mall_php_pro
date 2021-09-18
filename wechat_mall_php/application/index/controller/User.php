<?php

namespace app\index\controller;

use app\common\model\Users;
use app\common\utils\JwtUtil;
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

    public function loginAuthen()
    {
        $username = $this->request->post("username");
        $password = $this->request->post("userpwd");
        $ticket = $this->request->post("ticket");
        $randStr = $this->request->post("randstr");
        $appId = $this->request->post("appid");

        if($this->check($ticket,$randStr,$appId) == 1){
            $result = $this->userService->login($username, $password);
            if ($result != null) {
                $jwtUtil = new JwtUtil();
                $jwtEncode = $jwtUtil->jwtEncode($result["user_name"]);
                $result["user_token"] = $jwtEncode;
                $result->save();

                $data = ["token" => $result["user_token"]];
                return \json(["message" => "ok", "code" => 200, "data" => $data, "ok" => true]);
            } else {
                return \json(["message" => "验证失败", "code" => 201, "data" => null]);
            }
            return $result;
        }
    }

    public function registerAuthen()
    {
        $username = $this->request->post("username");
        $password = $this->request->post("userpwd");
        $ticket = $this->request->post("ticket");
        $randStr = $this->request->post("randstr");
        $appId = $this->request->post("appid");

        if($this->check($ticket,$randStr,$appId) == 1){
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

    public function check($ticket, $randStr,$appid)
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
        $content = $this->userService->txcurl($url,$paramstring);

        $result = json_decode($content,true);
//        json($result)->send();
//        exit();
        if($result){
            if($result['response'] == 1){
                return 1;
            }else{
                echo $result['response'].":".$result['err_msg'];
            }
        }else{

            echo $content;
        }
    }
}
