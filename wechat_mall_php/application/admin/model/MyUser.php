<?php

namespace app\admin\model;

use think\Model;

class MyUser extends Model
{
    protected $pk = "user_id";

    public function roles()
    {
        return $this->belongsToMany('Roles');
    }
}