<?php

namespace app\common\service;

use app\admin\controller\Goods;
use app\common\model\Goods as GoodsModel;
use app\common\model\ImageUrl as ImageUrlModel;
use app\common\model\OrdersGoods as OrderGoodsModel;
use app\common\model\Comment as CommentModel;
use app\common\model\Users as UserModel;
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
            $where[] = ["goods_introduce", "like", "%" . $query["goodsName"] . "%"];
        }

        if (array_key_exists("goodsCatThreeId", $query)) {
            $where[] = ["goods_cat_three_id", "=", $query["goodsCatThreeId"]];
        }

        $res = GoodsModel::page($page, $limit)->where($where)->select();

        $res = GoodsModel::where($where);

        $temp = null;
        if (array_key_exists("Datevalue", $query)) {
            $temp = $query["Datevalue"];
        }

        if (array_key_exists("sortColumn", $query) && array_key_exists("sortType", $query)) {
            if ($query["sortType"] == 'ascending') {
                $res = $res->order($query["sortColumn"], 'asc');
            } else {
                $res = $res->order($query["sortColumn"], 'desc');
            }
        }

        if($temp != null){
            $count = $res->whereBetweenTime("goods_add_time",$temp[0],$temp[1])->count();
            $res = $res->page($page, $limit)->whereBetweenTime("goods_add_time",$temp[0],$temp[1])->select();
        } else {
            $res = $res->page($page, $limit)->select();
            $count = GoodsModel::where($where)->count();
        }

        foreach ($res as $goods) {
            $imageUrlModel = new ImageUrlModel();
            $imageUrls = $imageUrlModel->where(["from" => 1, "f_id" => $goods["goods_id"]])->select();
            $pics = [];
            foreach ($imageUrls as $image) {
                array_push($pics, ["url" => $image["url"], "id" => $image["id"], "name" => $image["name"]]);
            }
            $goods["pics"] = $pics;
        }

        return ["page" => $page, "total" => $count, "content" => $res];
    }

    public function getCommentWithOrder($data)
    {
        $index = $data;
        $temp = OrderGoodsModel::where("order_goods_id",$index["goods_id"])->column("order_id");
        $where[] = ["order_id","in",$temp];
        $list = CommentModel::where($where)->select();
        for($i = 0;$i < count($list);$i++)
        {
            $temp = OrderGoodsModel::where("order_id",$list[$i]["order_id"])->find();
            $tmp = UserModel::where("user_id",$list[$i]["user_id"])->find();
            $list[$i]["order"] = $temp;
            $list[$i]["user_name"] = $tmp["user_name"];
        }
        return $list;
    }

}