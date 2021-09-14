<?php

namespace app\common\service;

use app\common\model\Goods as GoodsModel;
use app\common\utils\ResultUtil;
use think\Db;

class GoodsService
{
    public function getAllCategories()
    {
        $where1['cat_level'] = [1];
        $ctg1 = DB::name("category")->where($where1)->select();
        $mapList1 = array();
        for ($i = 0; $i < count($ctg1); $i++) {
            $index = $ctg1[$i];
            $map1 = array(
                "cat_id" => $index["cat_id"],
                "cat_name" => $index["cat_name"],
                "cat_pid" => $index["cat_pid"],
                "cat_level" => $index["cat_level"],
                "cat_deleted" => $index["cat_deleted"],
                "cat_icon" => $index["cat_icon"]);

            $mapList2 = array();
            $where2['cat_level'] = [2];
            $where2['cat_pid'] = [$index["cat_id"]];
            $ctg2 = DB::name("category")->where($where2)->select();
            for ($j = 0; $j < count($ctg2); $j++) {
                $temp1 = $ctg2[$j];
                $map2 = array(
                    "cat_id" => $temp1["cat_id"],
                    "cat_name" => $temp1["cat_name"],
                    "cat_pid" => $temp1["cat_pid"],
                    "cat_level" => $temp1["cat_level"],
                    "cat_deleted" => $temp1["cat_deleted"],
                    "cat_icon" => $temp1["cat_icon"]);

                $mapList3 = array();
                $where3['cat_level'] = [3];
                $where3['cat_pid'] = [$temp1["cat_id"]];
                $ctg3 = DB::name("category")->where($where3)->select();
                for ($k = 0; $k < count($ctg3); $k++) {
                    $temp2 = $ctg3[$k];
                    $map3 = array(
                        "cat_id" => $temp2["cat_id"],
                        "cat_name" => $temp2["cat_name"],
                        "cat_pid" => $temp2["cat_pid"],
                        "cat_level" => $temp2["cat_level"],
                        "cat_deleted" => $temp2["cat_deleted"],
                        "cat_icon" => $temp2["cat_icon"]);
                    array_push($mapList3, $map3);
                }
                $map2["children"] = $mapList3;
                array_push($mapList2, $map2);
            }
            $map1["children"] = $mapList2;
            array_push($mapList1, $map1);
        }
        return $mapList1;
    }

    public function goodsDetail($goods_id)
    {
        $goods = GoodsModel::where('goods_id', $goods_id)->find();

        if (is_null($goods)) {
            json(["message" => $goods, "meta" => ["msg" => "找不到商品ID", "status" => 400]])->send();
            exit();
        }

        $url[] = [
            "pics_sma" => $goods["goods_pic_one"],
            "pics_mid" => $goods["goods_pic_one"],
            "pics_big" => $goods["goods_pic_one"],
        ];
        $url[] = [
            "pics_sma" => $goods["goods_pic_two"],
            "pics_mid" => $goods["goods_pic_two"],
            "pics_big" => $goods["goods_pic_two"],
        ];
        $url[] = [
            "pics_sma" => $goods["goods_pic_three"],
            "pics_mid" => $goods["goods_pic_three"],
            "pics_big" => $goods["goods_pic_three"],
        ];
        $goods["pics"] = $url;

        return $goods;
    }

    public function search($query, $cid)
    {
        $where = [];
        if (!is_null($query) && ($query != '')) {
            $where[] = ['goods_name|goods_introduce', 'like', "%" . $query . "%"];
        }
        if (!is_null($cid) && ($cid != '')) {
            $where[] = ['goods_cat_three_id', "=", $cid];
        }
        return $goods = GoodsModel::where($where)->select();
    }

    public function pageSearch($page = null, $limit = null, $query)
    {
        $where = array();
        $where[] = ["goods_state", "<>", 0];

        if (array_key_exists("goodsName", $query)) {
            $where[] = ["goods_name", "like", "%" . $query["goodsName"] . "%"];
        }
        if (array_key_exists("goodsIntroduce", $query)) {
            $where[] = ["goods_introduce", "like", "%" . $query["goodsIntroduce"] . "%"];
        }

        $res = GoodsModel::page($page, $limit)->where($where)->select();
        $count = GoodsModel::where($where)->count();

        return ["page" => $page, "total" => $count, "content" => $res];
    }

}