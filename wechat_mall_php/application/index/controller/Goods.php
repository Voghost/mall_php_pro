<?php

namespace app\index\controller;

use app\common\utils\ResultUtil;
use think\App;
use think\Controller;

class Goods extends Controller
{
    private $goodsService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->goodsService = \think\facade\App::model("goods", "service", true);
    }

    public function categoriesList()
    {
        $allCategories = $this->goodsService->getAllCategories();
        return ResultUtil::OK($allCategories);
    }

    public function search($query = '', $cat_id = '')
    {
        $search = $this->goodsService->search($query, $cat_id);
        $res = [];
        for ($i = 0; $i < count($search); $i++) {
            array_push($res,["value"=> $search[$i]["goods_name"],"id"=>$search[$i]["goods_id"]]);
        }
        return ResultUtil::OK($res);

    }

}