<?php

namespace app\common\service;

use app\common\model\Users as UsersModel;
use app\common\utils\JwtUtil;
use DateTime;

class UserService
{

    public function login($username, $password)
    {
        $passwordMd5 = md5($password);
        $usersModel = new UsersModel();

        $collection = $usersModel->where(["user_name" => $username, "user_password" => $passwordMd5])->select();

        if (count($collection) < 1) {
            return null;
        } else {
            return $collection[0];
        }
    }

    public function register($username, $password)
    {
        $usersModel = new UsersModel();
        $users = $usersModel->where("user_name", $username)->find();
        if ($users != null) {
            json(["message" => "用户名已存在", "meta" => ["code" => 201]])->send();
            exit();
        }
        $dt = new DateTime();
        $time = $dt->format('Y-m-d H:i:s');
        $usersModel->save(["user_name" => $username, "user_password" => md5($password), "user_create_time" => $time]);
    }


    /**
     * @param $code
     * @return \think\response\Json
     */
    public function wxLogin($code)
    {
        //        $code = input('code'); //用户的登录凭证code（使用wx.login({})可获取到）这个是前端传过来
        $appid = \config("app.app_id");
        $secret = \config("app.app_secret");
        //        $appid = 'wx899****'; //微信公众平台看
        //        $secret = 'ddb******';//微信公众平台看
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
        $wechat = file_get_contents($url);
        $json_decode = json_decode($wechat);
        $array = get_object_vars($json_decode);
        if (!array_key_exists("openid", $array)) {
            return json(["message" => "获取openid出错", "code" => 201, "data" => null]);
        }
        $openid = $array["openid"];

        $user = UsersModel::where("user_openid", $openid)->find();
        $jwtUtil = new JwtUtil();
        $token = $jwtUtil->jwtEncode($openid);
        // 如果不存在用户
        if ($user == null) {
            $user = new UsersModel();
            $user->user_openid = $openid;
            $user->user_create_time = date('Y-m-d H:i:s');
            $user->user_update_time = date('Y-m-d H:i:s');
            $user->user_last_login_time = date('Y-m-d H:i:s');
            $user->user_is_active = 1;
        } else {
            $user->user_last_login_time = date('Y-m-d H:i:s');
        }
        $user->user_token = $token;
        $user->save();

        return json([
            "message" => [
                "user_id" => $user->user_id,
                "token" => $user->user_token
            ],
            "meta" => [
                "msg" => "登陆成功",
                "status" => 200
            ]
        ]);
    }

    function txcurl($url, $params = false, $ispost = 0)
    {
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'JuheData');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);
        if ($response === FALSE) {
            echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }

    public function updateUser($user, $map)
    {
        $usersModel = new UsersModel();
        $user = $usersModel->where(["user_id" => $user["user_id"]])->find();
        if (array_key_exists("user_avatar", $map)) {
            $user->user_avatar = $map["user_avatar"];
        }
        if (array_key_exists("user_age", $map)) {
            $user->user_age = $map["user_age"];
        }

        if (array_key_exists("user_email", $map)) {
            $user->user_email = $map["user_email"];
        }
        if (array_key_exists("user_sex", $map)) {
            $user->user_sex = $map["user_sex"];
        }
        $dt = new DateTime();
        $time = $dt->format('Y-m-d H:i:s');
        $user->user_update_time = $time;
        $user->save();
    }

    public function show()
    {
        $arr = ["a" => "111", "b" => "aaab"];
        return json($arr);
    }


}