<?php
/**
 * @author  刘凌峰
 */

namespace app\http\middleware;

use think\Request;
use app\common\utils\JwtUtil;
use app\admin\model\MyUser as MyUserModel;

class VerifyMyUser
{
    public function handle(Request $request, \Closure $next)
    {
//        $token = $request->header('token');
        $token = $request->header('Authorization');
        // token 不存在 返回 201
        if (!isset($token) || $token == "" || $token == null) {
//            return response()->content(["message" => "token不存在", "code" => 201, "data" => null]);
            return json(["message" => "token不存在", "code" => 201, "data" => null]);
        }
        $jwtUtil = new JwtUtil();
        $res = $jwtUtil->jwtDecode($token);
        // token 出错
        if ($res["code"] == 201) {
            return json($res);
        }
        $myUser = MyUserModel::where("user_name", $res["message"])->find();
        if (is_null($myUser) || !isset($myUser)) {
            return json(["message" => "用户不存在", "code" => 201, "data" => null]);
        }
        if ($myUser->user_token != $token) {
            return json(["message" => "token失效", "code" => 201, "data" => null]);
        }
        return $next($request);
//        return json($myUser);
    }
}