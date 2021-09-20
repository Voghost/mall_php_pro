<?php

namespace app\admin\controller;

use app\common\service\GoodsService;
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

    public function allKey()
    {
        $allSpecKey = $this->specService->getAllSpecKey();
        return \json(['message' => 'ok', "code" => 200, 'data' => $allSpecKey]);
    }

    public function specTree()
    {
        $specTree = $this->specService->getSpecTree();
        return \json(['message' => 'ok', "code" => 200, 'data' => $specTree]);
    }

    public function getSpecKeyByIds()
    {
        $post = $this->request->post("ids");
        if ($post != "") {
            $specKeyByIds = $this->specService->getSpecKeyByIds($post);
            return \json(['message' => 'ok', "code" => 200, 'data' => $specKeyByIds]);
        }
    }

    public function getGoodsAllSpec($goodsId)
    {
        $specKVByGoodsId = $this->specService->getSpecKVByGoodsId($goodsId);
        return \json(['message' => 'ok', "code" => 200, 'data' => $specKVByGoodsId]);
    }

    public function getValueFromSpecKey($specKey)
    {
        $specFromSpecKey = $this->specService->getSpecFromSpecKey($specKey);
        return \json(['message' => 'ok', "code" => 200, 'data' => $specFromSpecKey]);
    }

    public function addSpecKey()
    {

        $post = $this->request->post("spec_name");
        if ($post != null) {
            $this->specService->addSpecKey($post);
            return \json(['message' => 'ok', "code" => 200, 'data' => null]);
        } else {
            return \json(['message' => '请输入有效值', "code" => 201, 'data' => null]);
        }
    }

    public function addSpecValue()
    {

        $specVal = $this->request->post("specValName");
        $specKeyId = $this->request->post("specKid");
        if ($specVal != null && $specKeyId != null) {
            $this->specService->addSpecValue($specVal, $specKeyId);
            return \json(['message' => 'ok', "code" => 200, 'data' => null]);
        } else {
            return \json(['message' => '请输入有效值', "code" => 201, 'data' => null]);
        }
    }


    public function deleteSpecKey($id)
    {
        if ($id != null) {
            $this->specService->deleteSpecKey($id);
            return \json(['message' => 'ok', "code" => 200, 'data' => null]);
        } else {
            return \json(['message' => '无id', "code" => 203, 'data' => null]);
        }
    }

    public function deleteSpecValue($id)
    {
        if ($id != null) {
            $deleteSpecValue = $this->specService->deleteSpecValue($id);
            return \json(['message' => 'ok', "code" => 200, 'data' => $deleteSpecValue]);
        } else {
            return \json(['message' => '无id', "code" => 203, 'data' => null]);
        }
    }

    public function getSpecTableAndKV($goodsId)
    {
        if ($goodsId != null) {
            $res = $this->specService->getSpecTable($goodsId);
            return \json(['message' => 'ok', "code" => 200, 'data' => $res]);
        } else {
            return \json(['message' => 'fail', "code" => 202, 'data' => null]);
        }

    }


}