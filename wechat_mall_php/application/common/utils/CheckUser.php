<?php


namespace app\common\utils;


use app\common\model\Users as UsersModel;

class CheckUser
{
    static function checkUser($request){
        $token = $request->header('Authorization');
        if($token!=null){
            $userTemp = UsersModel::where("user_token", $token)->find();
            if($userTemp == null){
                json(["message" => "未找到用户","token" => $token])->send();
                exit;
            } else {
                return $userTemp;
            }
        }
    }
}