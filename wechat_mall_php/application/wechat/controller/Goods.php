<?php

namespace app\wechat\controller;

use app\common\model\ImageUrl as ImageUrlModel;
use think\App;
use think\Controller;
use app\common\model\Goods as GoodsModel;
use think\DB;

class Goods extends Controller
{
    private $goodsService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->goodsService = \think\facade\App::model("goods", "service", true);
    }

    public function categories()
    {
        $allCategories = $this->goodsService->getAllCategories();
        return json(["message" => $allCategories]);
    }


    public function detail($goods_id)
    {
        $goods = $this->goodsService->goodsDetail($goods_id);
        $imageUrlModel = new ImageUrlModel();
        $imageUrls = $imageUrlModel->where(["from" => 1, "f_id" => $goods["goods_id"]])->select();

        for ($i = 0; $i < 3; $i++) {
            $url[] = [
                "pics_sma" => $imageUrls[$i]["url"],
                "pics_mid" => $imageUrls[$i]["url"],
                "pics_big" => $imageUrls[$i]["url"],
            ];
        }
        $goods["pics"] = $url;
        return json(["message" => $goods, "meta" => ["msg" => "获取成功", "status" => 200]]);
    }


    public function search($query = null, $cid = null, $pageNum = null, $pageSize = null)
    {
        $goods = $this->goodsService->search($query, $cid);
        $list = DB::name("goods")->select();
        $total = count($list);
        return json(["message" => ["total" => $total, "pageNum" => $pageNum, "goods" => $goods], "meta" => ["msg" => "获取成功", "status" => "200"]]);
    }


    public function qsearch($query)
    {
        $where[] = ['goods_name|goods_introduce', 'like', "%" . $query . "%"];
        $goods = GoodsModel::where($where)->select();
        return json(["message" => $goods, "meta" => ["msg" => "获取成功", "status" => "200"]]);
    }


}