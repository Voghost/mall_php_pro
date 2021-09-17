<?php


namespace app\common\model;


use think\Model;

class Cart extends Model
{


    public function goods()
    {
        return $this->belongsToMany('Goods','cart','goods_info_id','id');

    }
    public function users(){
        return $this->belongsToMany('Users','cart','user_id','id');
    }
}