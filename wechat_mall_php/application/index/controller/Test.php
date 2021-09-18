<?php

namespace app\index\controller;

use app\common\model\Goods as GoodsModel;
use app\common\model\GoodsInfo;
use app\common\model\ImageUrl as ImageUrlModel;
use app\common\model\SpecKeyValue;
use app\common\model\SpecValue;

class Test
{
    public function filterArr($value, $key)
    {
        return true;
    }

    public function test()
    {

        $goodsInfo = new GoodsInfo();
        $specKeyValue = new SpecKeyValue();
        $gEq1 = $goodsInfo->where(["goods_id" => 1])->select();

        $arr = [];
        foreach ($gEq1 as $g) {
            $select = $specKeyValue->where(["goods_info" => $g["info_id"]])->select();
//            $arr = array_merge($arr, $select->toArray());
            $arr = array_filter($select->toArray(), function ($v, $k) {
                return ($v["spec_key"] == 1 && $v["spec_value"] == 1) || ($v["spec_key"] == 2 && $v["spec_value"] == 5);
            }, ARRAY_FILTER_USE_BOTH);
            if (count($arr) > 0) {
                return json($arr);
            }
        }

        /*        $arr = array_filter($arr, function ($v, $k) {
                    //            return $k > 2;
                    return ($v["spec_key"] == 1 && $v["spec_value"] == 1) || ($v["spec_key"] == 2 && $v["spec_value"] == 4);
                    //            return true;
                }, ARRAY_FILTER_USE_BOTH);*/

//        return json($arr);

    }

//        $collection = GoodsModel::select();
//
//        for ($i = 0; $i < count($collection); $i++) {
//            $image = new ImageUrlModel();
//            $image->from = 1;
//            $image->url = $collection[$i]['goods_pic_one'];
//            $image->f_id = $collection[$i]['goods_id'];
//            $image->save();
//        }
//
//        for ($i = 0; $i < count($collection); $i++) {
//            $image = new ImageUrlModel();
//            $image->from = 1;
//            $image->url = $collection[$i]["goods_pic_two"];
//            $image->f_id = $collection[$i]["goods_id"];
//            $image->save();
//        }
//
//        for ($i = 0; $i < count($collection); $i++) {
//            $image = new ImageUrlModel();
//            $image->from = 1;
//            $image->url = $collection[$i]["goods_pic_three"];
//            $image->f_id = $collection[$i]["goods_id"];
//            $image->save();
//        }
//        echo count($collection);
//        echo "  finish ";
}