<?php

namespace app\admin\controller;

use app\common\model\Swiperdata as SwiperModel;
use app\common\model\Floor as FloorModel;
use app\common\model\Goods as GoodsModel;
use think\Controller;

class Home extends Controller
{
    public function allSwiper()
    {
        $res = SwiperModel::all();
        $count = count($res);

        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => [
                    "content" => $res
                ]
            ]
        );
    }

    public function allFloor()
    {
        $res = FloorModel::all();
        $count = count($res);

        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => [
                    "content" => $res
                ]
            ]
        );
    }

    public function deleteSwiper()
    {
        $query = $this->request->post();
        $res = SwiperModel::where("goods_id", $query["goods_id"])->delete();
        if ($res > 0) {
            return \json(["message" => '删除成功', "code" => 200]);
        } else {
            return \json(["message" => '参数错误', "code" => 200]);
        }
    }

    public function deleteFloor()
    {
        $query = $this->request->post();
        $res = FloorModel::where("floor_id", $query["floor_id"])->delete();
        if ($res > 0) {
            return \json(["message" => '删除成功', "code" => 200]);
        } else {
            return \json(["message" => '参数错误', "code" => 200]);
        }
    }

    public function saveOrUpdateSwiper()
    {
        $query = $this->request->post();
        $count = 0;
        if (!array_key_exists("swiper_id", $query) || $query["swiper_id"] == "") {
            $swiper = new SwiperModel();
        } else {
            $swiper = SwiperModel::WHERE("swiper_id", $query["swiper_id"])->find();
        }

        if (GoodsModel::where("goods_id", $query["goods_id"])->find() == null) {
            return \json(["message" => '找不到此商品', "code" => 400]);
        }

        if (array_key_exists("image_src", $query)) {
            $swiper->image_src = $query['image_src'];
            $swiper->navigator_url = "/pages/goods_detail/index?goods_id" . $query["goods_id"];
            $count++;
        }

        if (array_key_exists("goods_id", $query)) {
            $swiper->goods_id = $query['goods_id'];
            $count++;
        }

        if ($count > 0) {
            $swiper->save();
        }

        return \json(['message' => 'ok', "code" => 200, 'data' => $swiper]);
    }

    public function saveOrUpdateFloor()
    {
        $query = $this->request->post();
        $count = 0;
        if (!array_key_exists("floor_id", $query) || $query["floor_id"] == "") {
            $floor = new FloorModel();
        } else {
            $floor = FloorModel::WHERE("floor_id", $query["floor_id"])->find();
        }

        if (array_key_exists("floor_image", $query)) {
            $floor->floor_image = $query['floor_image'];
            $count++;
        }

        if (array_key_exists("floor_name", $query)) {
            $floor->floor_name = $query['floor_name'];
            $count++;
        }

        if (array_key_exists("floor_keyword", $query)) {
            $floor->floor_keyword = $query['floor_keyword'];
            $count++;
        }

        if (array_key_exists("floor_weight", $query)) {
            $floor->floor_weight = $query['floor_weight'];
            $count++;
        }

        if ($count > 0) {
            $floor->save();
        }

        return \json(['message' => 'ok', "code" => 200, 'data' => $floor]);
    }
}