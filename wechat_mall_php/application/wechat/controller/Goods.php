<?php

namespace app\wechat\controller;

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
        $goodsDetail = $this->goodsService->goodsDetail($goods_id);
        return json(["message" => $goodsDetail, "meta" => ["msg" => "获取成功", "status" => 200]]);
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