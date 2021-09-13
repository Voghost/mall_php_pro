<?php

namespace app\common\utils;

use Firebase\JWT\JWT;

class JwtUtil
{
    public function jwtEncode($value)
    {
        $key = \config("app.jwt_key");

        $token = array(
            "iss" => "https://wechat-mall.ghovos.com",
            "aud" => "https://wechat-mall.ghovos.com/admin/login",
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + 60 * 60 * 24 * 30,        // 最后期限
            "sub" => $value,
        );

        return "Bearer " . JWT::encode($token, $key);
    }

    /** 解密token
     *
     * @param $token
     * @return array
     */
    public function jwtDecode($token)
    {
        $key = \config("app.jwt_key");//key值 定义在config下的app的jwt_key
        $exp = \explode(" ", $token);

        if (count($exp) < 2) {
            return ["code" => 201, "message" => "token 格式错"];
        }

        $token_type = $exp[0];//根据空格隔开获取第零个字符串
        $token = $exp[1];//根据空格隔开获取第一个字符串
        $decoded = false;

        if ($token_type == 'Bearer')//判断$token_type是否正确
        {
            try {
                $decoded = JWT::decode($token, $key, array('HS256'));//解密

                // 如果时间超出
                if ($decoded->exp < time()) {
                    return ["code" => 201, "message" => "token过期"];
                }
            } catch (\Exception $e) { //捕获异常，返回401，可能解密失败，$e可返回失败原因
                return ["code" => 201, "message" => $e->getMessage()];
            }
        } else {
            return ["code" => 201, "message" => "token 类型出错"];
        }
        return ["code" => 200, "message" => $decoded->sub];
    }
}