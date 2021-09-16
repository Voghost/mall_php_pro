<?php
namespace app\common\model;

use think\App;
use think\Model;

class Comment extends Model
{

    public function goods()
    {
        return $this->hasMany('Goods','goods_id','goods_id');
    }

    public function orders_goods()
    {
        return$this->hasMany('Ordergoods','order_id','order_id');
    }
}