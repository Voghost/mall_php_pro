<?php

namespace app\common\service;

use app\admin\controller\Goods;
use app\common\model\Category as CategoryModel;
use app\common\model\Goods as GoodsModel;
use app\common\model\GoodsInfo;
use app\common\model\ImageUrl as ImageUrlModel;
use app\common\model\OrdersGoods as OrderGoodsModel;
use app\common\model\Comment as CommentModel;
use app\common\model\SpecKeyValue;
use app\common\model\SpecValue;
use app\common\model\Users as UserModel;
use app\common\utils\ResultUtil;
use think\Db;

class GoodsService
{
    public function getAllCategories()
    {
        $where1['cat_level'] = [1];
        $ctg1 = DB::name("category")->where($where1)->where(['cat_deleted' => 0])->select();
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
            $ctg2 = DB::name("category")->where($where2)->where(['cat_deleted' => 0])->select();
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
                $ctg3 = DB::name("category")->where($where3)->where(['cat_deleted' => 0])->select();
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
            $where[] = ["goods_name | goods_introduce", "like", "%" . $query["goodsName"] . "%"];
        }
        if (array_key_exists("goodsIntroduce", $query)) {
            $where[] = ["goods_introduce", "like", "%" . $query["goodsName"] . "%"];
        }
//        json($query)->send();
//        exit();
//        $where[] = ["goods_cat_three_id", "=", $query["goodsCatThreeId"]];
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

        if ($temp != null) {
            $count = $res->whereBetweenTime("goods_add_time", $temp[0], $temp[1])->count();
            $res = $res->page($page, $limit)->whereBetweenTime("goods_add_time", $temp[0], $temp[1])->select();
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
        $temp = OrderGoodsModel::where("order_goods_id", $index["goods_id"])->column("order_id");
        $where[] = ["order_id", "in", $temp];
        $list = CommentModel::where($where)->select();
        for ($i = 0; $i < count($list); $i++) {
            $temp = OrderGoodsModel::where("order_id", $list[$i]["order_id"])->find();
            $tmp = UserModel::where("user_id", $list[$i]["user_id"])->find();
            $list[$i]["order"] = $temp;
            $list[$i]["user_name"] = $tmp["user_name"];
        }
        return $list;
    }

    public function saveOrUpdateGoods($query)
    {
        $count = 0;
        if (!array_key_exists("goodsId", $query) || $query["goodsId"] == "") {
            $goods = new GoodsModel();
            $goods->goods_add_time = date('Y-m-d H:i:s');
        } else {
            $goods = GoodsModel::where("goods_id", $query["goodsId"])->find();
        }

        if (array_key_exists("goodsName", $query) && $query['goodsName'] != "") {
            $goods->goods_name = $query['goodsName'];
            $count++;
        }
        if (array_key_exists("goodsPrice", $query)) {
            $goods->goods_price = $query['goodsPrice'];
            $count++;
        }
        if (array_key_exists("goodsNumber", $query)) {
            $goods->goods_number = $query['goodsNumber'];
            $count++;
        }
        if (array_key_exists("goodsWeight", $query)) {
            $goods->goods_weight = $query['goodsWeight'];
            $count++;
        }
        if (array_key_exists("goodsIntroduce", $query)) {
            $goods->goods_introduce = $query['goodsIntroduce'];
            $count++;
        }
        if (array_key_exists("goodsBigLogo", $query)) {
            $goods->goods_big_logo = $query['goodsBigLogo'];
            $goods->goods_small_logo = $query['goodsBigLogo'];
            $count++;
        }
        if (array_key_exists("goodsState", $query)) {
            $goods->goods_state = $query['goodsState'];
            $count++;
        }
        if (array_key_exists("goodsCatThreeId", $query)) {
            $goods->goods_cat_three_id = $query['goodsCatThreeId'];
            $categoryThree = CategoryModel::get($query['goodsCatThreeId']);
            $categoryTwo = CategoryModel::get($categoryThree->cat_pid);
            $categoryOne = CategoryModel::get($categoryTwo->cat_pid);
            $goods->goods_cat_two_id = $categoryTwo->cat_id;
            $goods->goods_cat_one_id = $categoryOne->cat_id;
            $count++;

        }


        // TODO 图片存入图库
//        if (array_key_exists("goodsPicOne", $query)) {
//            $goods->goods_pic_one = $query['goodsPicOne'];
//            $count++;
//        }
//        if (array_key_exists("goodsPicTwo", $query)) {
//            $goods->goods_pic_two = $query['goodsPicTwo'];
//            $count++;
//        }
//        if (array_key_exists("goodsPicThree", $query)) {
//            $goods->goods_pic_three = $query['goodsPicThree'];
//            $count++;
//        }


        // 如果有数据修改或添加
        if ($count > 0) {
            $goods->goods_upd_time = date('Y-m-d H:i:s');
            $goods->save();
        }
        if (array_key_exists("pics", $query)) {
            foreach ($query["pics"] as $pic) {
                $imageUrl = new ImageUrlModel();
                $imageUrl->name = $pic["name"];
                $imageUrl->url = $pic["url"];
                $imageUrl->from = 1;
                $imageUrl->f_id = $goods["goods_id"];
                $imageUrl->save();
            }
        }

        if (array_key_exists("goodsInfo", $query)) {
            $goodsInfoList = $query['goodsInfo'];
            foreach ($goodsInfoList as $goodsInfo) {


                $priceAndStock = $goodsInfo[count($goodsInfo) - 1];

                $specKeyValueModel = new SpecKeyValue();
                $goodsInfoModel = new GoodsInfo();

                // 如果是更新商品数据
                if (array_key_exists("goodsId", $query) && array_key_exists("info_id", $priceAndStock)) {
                    $goodsInfoUpdate = $goodsInfoModel->where(["info_id" => $priceAndStock["info_id"]])->find();
                    $goodsInfoUpdate->goods_price = $priceAndStock["price"];
                    $goodsInfoUpdate->goods_stock = $priceAndStock["stock"];
                    $goodsInfoUpdate->save();
                } else {
                    $insertGoodsInfo = $goodsInfoModel->insertGetId([
                        "goods_id" => $goods["goods_id"],
                        "goods_stock" => $priceAndStock["stock"],
                        "goods_price" => $priceAndStock["price"]
                    ]);
                    $contentStr = "";
                    $contentArr = [];
                    for ($i = 0; $i < count($goodsInfo) - 1; $i++) {
                        $specValue = new SpecValue();
                        $collection = $specValue->where(["spec_value_id" => $goodsInfo[$i]["id"]])->find();
                        $specKeyValueModel->insert([
                            "spec_key" => $collection["spec_id"],
                            "spec_value" => $collection["spec_value_id"],
                            "goods_info" => $insertGoodsInfo
                        ]);
//                        $contentStr .= $collection["spec_id"] . ":" . $collection["spec_value_id"] . ",";
                        array_push($contentArr, [
                            "spec_key" => $collection["spec_id"],
                            "spec_value" => $collection["spec_value_id"]
                        ]);
                    }
                    $idArr = array_column($contentArr, 'spec_key');
                    array_multisort($idArr, SORT_ASC, $contentArr);
                    foreach ($contentArr as $content) {
                        $contentStr .= $content["spec_key"] . ":" . $content["spec_value"] . ",";
                    }

                    $goodsInfoSaveContent = $goodsInfoModel->where(["info_id" => $insertGoodsInfo])->find();
                    $goodsInfoSaveContent->content = $contentStr;
                    $goodsInfoSaveContent->save();
                }
            }
        }

    }

}