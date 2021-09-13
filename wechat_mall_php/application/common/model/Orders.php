<?php
namespace app\common\model;

use think\Model;

class Orders extends Model{
    protected $pk = "order_id";

    public function goods()
    {
        return $this->belongsToMany('Goods','orders_goods',"order_goods_id","order_id");
    }
}
