<?php

namespace app\common\model;

use think\Model;

class Category extends Model
{
    protected $pk = "cat_id";

    public function goods()
    {
        return $this->hasMany("Goods");
    }
}
