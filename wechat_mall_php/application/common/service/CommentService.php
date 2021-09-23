<?php

namespace app\common\service;

use app\common\model\Goods;
use app\common\model\Goods as GoodsModel;
use app\common\model\ImageUrl;
use DateTime;
use think\Db;
use app\common\model\Comment as CommentModel;
use app\common\model\OrdersGoods as OrdersGoodsModel;
use app\common\model\ImageUrl as ImageUrlModel;
use app\common\model\Users as UserModel;

class CommentService
{
    public function getAllComment()
    {
        $where[] = ["status", "<>", 1];
        $list = CommentModel::where($where)->select();
        $temp = array();
        for ($i = 0; $i < count($list); $i++) {
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
            array_push($temp, $map);
        }
        return $temp;
    }

    public function getGoodsAndOrder($data)
    {
        $where = $data;
        $temp1 = new CommentModel();
        $index1 = $temp1->where("id", $where["id"])->find();
        $temp2 = new OrdersGoodsModel();
        $index2 = $temp2->where("order_id", $where["order_id"])->where("order_goods_id", $where["goods_id"])->find();
        $index1["order"] = $index2;
        $temp3 = new GoodsModel();
        $index3 = $temp3->where("goods_id", $where["goods_id"])->find();
        $index1["goods"] = $index3;
        return $index1;
    }

    public function getAllCommentWithGoods($list)
    {
        $commentlist = array();
        for ($i = 0; $i < count($list); $i++) {
            $where = $list[$i]["goods_id"];
//            $temp1 = new CommentModel();
//            $index1 = $temp1->with('goods')->whereColumn("goods_id",$where)->findOrFail();
            $temp1 = new CommentModel();
            $index1 = $temp1->where("goods_id", $where)->find();
            $temp2 = new OrdersGoodsModel();
            $index2 = $temp2->where("order_id", $list[$i]["order_id"])->where("order_goods_id", $list[$i]["goods_id"])->find();
            $index1["order"] = $index2;
            $temp3 = new GoodsModel();
            $index3 = $temp3->where("goods_id", $where)->find();
            $index1["goods"] = $index3;
            array_push($commentlist, $index1);
        }
        return $commentlist;
    }



    public function getGoodsWithComment($goods_id)
    {
        $where = $goods_id;
        $temp = new CommentModel();
        $list = $temp->with('goods')->whereColumn("goods_id", $where)->findOrFail();
        return $list;
    }

    public function pageSearch($page, $limit, $goodsId)
    {
        $commentModel = new CommentModel();
        $comment = $commentModel->where(["goods_id" => $goodsId]);
        $commentList = $comment->page($page, $limit)->select();

        $imageUrlModel = new ImageUrlModel();
        $usersModel = new UserModel();

        foreach ($commentList as $comment) {
            $imageUrlList = $imageUrlModel->where(["f_id" => $comment["id"], "from" => 2])->select();
            $users = $usersModel->where(["user_id" => $comment["user_id"]])->find();
            $pic = [];
            foreach ($imageUrlList as $image) {
                array_push($pic, $image["url"]);
            }
            $comment["pics"] = $pic;
            $comment["username"] = $users["user_name"];

        }
        $collection = $commentModel->where(["goods_id" => $goodsId])->select();
        $total = 0;
        foreach ($collection as $item) {
            $total += $item["star"];
        }

        return ["content" => $commentList, "total" => count($collection), "page" => (int)$page, "rate" => ($total / (5 * count($collection)))];
    }

    public function pageSearchAdmin($page = null, $limit = null, $query)
    {
        $where = array();
        $index = array();
        $where[] = ["status", "<>", 2];
        $whereOr = null;

        if (array_key_exists("goodsName", $query)) {
            $where[] = ["content", "like", "%" . $query["goodsName"] . "%"];
            $index[] = ["goods_name", "like", "%" . $query["goodsName"] . "%"];
            $temp = GoodsModel::where($index)->column('goods_id');
            $whereOr[] = ["status", "<>", 2];
            $whereOr[] = ["goods_id", "in", $temp];
        }

        if ($whereOr != null) {
            $res = CommentModel::page($page, $limit)->where([$where])->whereOr([$whereOr])->select();
            $count = CommentModel::where([$where])->whereOr([$whereOr])->count();
        } else {
            $res = CommentModel::page($page, $limit)->where($where)->select();
            $count = CommentModel::where($where)->count();
        }
        for ($i = 0; $i < count($res); $i++) {
            $temp = $res[$i];
            $name = UserModel::where("user_id", $temp["user_id"])->column("user_name");
            $res[$i]["user_name"] = $name[0];
        }

        foreach ($res as $comment) {
            $imageUrlModel = new ImageUrlModel();
            $imageUrls = $imageUrlModel->where(["from" => 2, "f_id" => $comment["id"]])->select();
            $pics = [];
            foreach ($imageUrls as $image) {
                array_push($pics, ["url" => $image["url"], "id" => $image["id"], "name" => $image["name"]]);
            }
            $comment["pics"] = $pics;
        }
        return ["page" => $page, "total" => $count, "content" => $res];
    }

    public function addComment($query, $user)
    {
        $comment = new CommentModel();
        $comment->content = $query["content"];
        $comment->order_id = $query["order_id"];
        $comment->star = $query["star"];
        $comment->goods_id = $query["goods_id"];
        $comment->user_id = $user->user_id;
        $comment->status = 0;
        $dt = new DateTime();
        $time = $dt->format('Y-m-d H:i:s');
        $comment->time = $time;
        $id = $comment->save();

        $picTemp = $query["pics"];
        for ($i = 0;$i < count($picTemp);$i++)
        {
            $temp = $picTemp[$i];
            $pic = new ImageUrlModel();
            $pic["from"] = 2;
            $pic["url"] = $temp["url"];
            $pic["name"] = $temp["name"];
            $pic["f_id"] = $id;
            $pic->save();
        }

        return 1;
    }
}
