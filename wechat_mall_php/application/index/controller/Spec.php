<?php

namespace app\index\controller;

use app\common\model\GoodsInfo;
use app\common\utils\ResultUtil;
use think\App;
use think\Controller;

class Spec extends Controller
{
    private $specService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->specService = \think\facade\App::model("spec", "service", true);

    }

    public function getSpecKvInfoByGoodsId($goodsId)
    {
        $specKvInfoByGoodsId = $this->specService->getSpecKvInfoByGoodsId($goodsId);
        return ResultUtil::OK($specKvInfoByGoodsId);
    }

    public function getGoodsInfoBySpecKv($goodsId)
    {
        $specKv = $this->request->post("specKv");
        $kvStr = '';
        foreach ($specKv as $key => $item) {
            $kvStr .= $key . ":" . $item["id"] . ",";
        }
        $goodsInfoModel = new GoodsInfo();
        $goodsInfo = $goodsInfoModel->where(["content" => $kvStr, "goods_id" => $goodsId])->find();
        return ResultUtil::OK($goodsInfo);
    }


    public function getKVByInfoId($id)
    {
        $KVByInfoId = $this->specService->getSpecKvByInfoId($id);
        return ResultUtil::OK($KVByInfoId);
    }

}