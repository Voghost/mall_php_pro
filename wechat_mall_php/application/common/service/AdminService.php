<?php

namespace app\common\service;
use app\common\model\MyUser;
use app\common\model\MyUser as MyUserService;
use app\common\model\MyUserRoles as MyUserRolesService;
use app\common\model\Roles as RolesService;

class AdminService
{
    public function adminList($data)
    {
        for($i = 0;$i < count($data);$i++)
        {
            $role_id = MyUserRolesService::where("my_user_id",$data[$i]["user_id"])->column("roles_id");
            $role = array();
            for($j = 0;$j < count($role_id);$j++)
            {
                $temp = RolesService::where("roles_id", $role_id[$j])->find();
                array_push($role,$temp["roles_name"]);
            }
            $data[$i]["role"] = $role;
        }

        return $data;
    }

    public function addAdmin($admin)
    {
        $myUser = new MyUser();
        $myUser->user_name = $admin["username"];
        $myUser->user_password = md5($admin["password"]);
        $myUser->avatar = md5($admin["avatar"]);
        $myUser->save();

        return 1;
    }
}