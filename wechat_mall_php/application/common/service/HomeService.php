<?php

namespace app\common\service;

use think\Db;

class HomeService
{
    public function floorList()
    {
        $message = array();
        $floorList = DB::name("floor")->select();
        if (is_null($floorList)) {
            json(["message" => null, "meta" => ["msg" => "获取失败", "status" => "400"]])->send();
            exit();
        }
        for ($i = 0; $i < count($floorList); $i++) {
            $index = $floorList[$i];
            $temp = array(
                "name" => $index["floor_name"],
                "image_src" => $index["floor_image"],
                "open_type" => "navigate",
                "navigator_url" => "/pages/goods_list?query=" . $index["floor_keyword"]
            );
            $floor_title = array("floor_title" => $temp);
            array_push($message, $floor_title);
        }
        return $message;
    }


    public function swiperList()
    {
        $swiperdata = DB::name("swiperdata")->select();
        if (is_null($swiperdata)) {
            return json(["message" => null, "meta" => ["msg" => "获取失败", "status" => 400]]);
        } else {
            return json(["message" => $swiperdata, "meta" => ["msg" => "获取成功", "status" => 200]]);
        }
    }


}