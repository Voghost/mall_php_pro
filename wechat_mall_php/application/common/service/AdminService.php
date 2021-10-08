<?php

namespace app\common\service;
use app\common\model\MyUser;
use app\common\model\MyUser as MyUserService;
use app\common\model\MyUserRoles;
use app\common\model\MyUserRoles as MyUserRolesService;
use app\common\model\Roles;
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
        $myUser->avatar = $admin["avatar"];
        $myUser->save();

        return 1;
    }

    public function getRole()
    {
        $list = RolesService::column("roles_name");
        return $list;
    }

    public function addRole($id, $item)
    {
        $role = new MyUserRoles();
        $role->my_user_id = $id;
        if($item == "ADMIN")
            $role->roles_id = 1;
        else if($item == "USER")
            $role->roles_id = 2;
        else if($item == "TEST")
            $role->roles_id = 3;
        else if($item == "sss")
            $role->roles_id = 4;
        $role->save();

        return 1;
    }

    public function deleteRole($id, $item)
    {
        $where[] = ["my_user_id", "=", $id];
        if($item == "ADMIN")
            $roles_id = 1;
        else if($item == "USER")
            $roles_id = 2;
        else if($item == "TEST")
            $roles_id = 3;
        else if($item == "sss")
            $roles_id = 4;
        $where[] = ["roles_id", "=", $roles_id];
        MyUserRoles::where($where)->delete();

        return 1;
    }
}