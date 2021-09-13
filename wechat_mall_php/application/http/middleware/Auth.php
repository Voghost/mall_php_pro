<?php
/**
 * @author 刘凌峰
 * 权限管理
 */

namespace app\http\middleware;

use app\common\utils\JwtUtil;
use think\Request;
use app\admin\model\MyUser as MyUserModel;

class Auth
{
    public function handle(Request $request, \Closure $next, $rolesList)
    {
        // 如果不需要权限, 直接进入控制器
        if ($rolesList == null || count($rolesList) <= 0) {
            return $next($request);
        }
        // 解密token
//        $token = $request->header('token');
        $token = $request->header('Authorization');
        $jwtUtil = new JwtUtil();
        $res = $jwtUtil->jwtDecode($token);

        // 查询是否存在用户
        $userList = MyUserModel::with("roles")->where("user_name", $res["message"])->find();

        // 权限判断
        $temp = 0;
        foreach ($userList->roles as $rol) {
            if (in_array($rol["roles_name"], $rolesList)) {
                $temp = $temp + 1;
            }
        }
        if ($temp < count($rolesList)) {
            return json(["message" => "无权限", "code" => 201, "data" => null]);
        }
        return $next($request);

    }

}
