<?php

namespace app\common\service;

use app\common\model\Users as UsersModel;
use app\common\utils\JwtUtil;

class UserService
{
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


    public function show()
    {
        $arr = ["a" => "111", "b" => "aaab"];
        return json($arr);
    }


}