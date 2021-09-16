<?php
namespace app\common\service;

use app\common\model\Goods;
use think\Db;
use app\common\model\Goods as GoodsModel;
use app\common\model\Comment as CommentModel;
use app\common\model\OrdersGoods as OrdersGoodsModel;

class CommentService
{
    public function getAllComment()
    {
        $where[] = ["status", "<>", 1];
        $list = CommentModel::where($where)->select();
        $temp = array();
        for($i = 0;$i < count($list);$i++)
        {
            $index = $list[$i];
            $map = array(
                "id" => $index["id"],
                "content" => $index["content"],
                "star" => $index["star"],
                "goods_id" => $index["goods_id"],
                "order_id" => $index["order_id"],
                "status" => $index["status"],
                "user_id" => $index["user_id"]
            );
            array_push($temp,$map);
        }
        return $temp;
    }

    public function getGoodsAndOrder($data)
    {
        $where = $data;
        $temp1 = new CommentModel();
        $index1 = $temp1->where("id",$where["id"])->find();
        $temp2 = new OrdersGoodsModel();
        $index2 = $temp2->where("order_id",$where["order_id"])->where("order_goods_id",$where["goods_id"])->find();
        $index1["order"] = $index2;
        $temp3 = new GoodsModel();
        $index3 = $temp3->where("goods_id",$where["goods_id"])->find();
        $index1["goods"] = $index3;
        return $index1;
    }

    public function getAllCommentWithGoods($list)
    {
        $commentlist = array();
        for($i = 0;$i <count($list);$i++)
        {
            $where = $list[$i]["goods_id"];
//            $temp1 = new CommentModel();
//            $index1 = $temp1->with('goods')->whereColumn("goods_id",$where)->findOrFail();
            $temp1 = new CommentModel();
            $index1 = $temp1->where("goods_id",$where)->find();
            $temp2 = new OrdersGoodsModel();
            $index2 = $temp2->where("order_id",$list[$i]["order_id"])->where("order_goods_id",$list[$i]["goods_id"])->find();
            $index1["order"] = $index2;
            $temp3 = new GoodsModel();
            $index3 = $temp3->where("goods_id",$where)->find();
            $index1["goods"] = $index3;
            array_push($commentlist,$index1);
        }
        return $commentlist;
    }

    public function getGoodsWithComment($goods_id)
    {
        $where = $goods_id;
        $temp = new CommentModel();
        $list = $temp->with('goods')->whereColumn("goods_id",$where)->findOrFail();
        return $list;
    }

    public function pageSearch($page = null, $limit = null, $query)
    {
        $where = array();
        $where[] = ["status", "<>", 2];

        if (array_key_exists("content", $query)) {
            $where[] = ["content", "like", "%" . $query["content"] . "%"];
        }

        $res = CommentModel::page($page, $limit)->where($where)->select();
        $count = CommentModel::where($where)->count();

        return ["page" => $page, "total" => $count, "content" => $res];
    }
}