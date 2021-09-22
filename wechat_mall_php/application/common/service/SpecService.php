<?php

namespace app\common\service;

use app\admin\controller\Spec;
use app\common\model\Goods;
use app\common\model\GoodsInfo;
use app\common\model\SpecKey;
use app\common\model\SpecKeyValue;
use app\common\model\SpecValue;
use think\route\Rule;

class SpecService
{
    // 获取所有属性
    public function getAllSpecKey()
    {
        $specKey = new SpecKey();
        $collection = $specKey->select();
        $arr = [];
        foreach ($collection as $item) {
            array_push($arr, ["key" => $item["spec_id"], "label" => $item["spec_name"]]);
        }
        return $arr;
    }

    public function getSpecKeyByIds($arr)
    {
        $specKey = new SpecKey();
        $collection = $specKey->whereIn("spec_id", $arr)->select();
        foreach ($collection as $item) {
            $specValue = new SpecValue();
            $valueArr = $specValue->where(["spec_id" => $item["spec_id"]])->select();
            $item["valueArr"] = $valueArr;
        }
        return $collection;
    }

    public function getSpecKVByGoodsId($goodsId)
    {
        $goodsInfo = new GoodsInfo();
        $specKeyValue = new SpecKeyValue();
        $gEq = $goodsInfo->where(["goods_id" => $goodsId])->select();

        $arr = [];
        foreach ($gEq as $g) {
            $select = $specKeyValue->where(["goods_info" => $g["info_id"]])->select();
            $arr = array_merge($arr, ["info:" . $g["info_id"] => $select->toArray()]);
        }
        return $arr;
    }

    public function getSpecFromSpecKey($specKey)
    {
        $specValue = new SpecValue();
        return $specValue->where(["spec_id" => $specKey])->select();
    }

    public function getSpecTree()
    {
        $specKey = new SpecKey();
        $collection = $specKey->select();
        $res = [];
        $count = 0;
        foreach ($collection as $item) {
            $specValue = new SpecValue();
            $valueList = $specValue->where(["spec_id" => $item["spec_id"]])->select();
            $temp = [];
            foreach ($valueList as $valueItem) {
                array_push($temp, [
                    "id" => "v" . $count++,
                    "val_id" => $valueItem["spec_value_id"],
                    "label" => $valueItem["spec_value"],
                    "type" => "value"
                ]);
            }
            array_push($res, [
                "id" => $item["spec_id"],
                "label" => $item["spec_name"],
                "children" => $temp,
                "type" => "key"
            ]);
        }
        return $res;
    }

    public function addSpecKey($specName)
    {
        $specKey = new SpecKey();
        $res = $specKey->where(["spec_name" => $specName])->find();

        if ($res != null) {
            json(["message" => "名字重复", "code" => 210, "data" => null])->send();
            exit();
        }
        $specKey->spec_name = $specName;
        $specKey->save();
    }

    public function addSpecValue($specVal, $specKeyId)
    {
        $specValue = new SpecValue();
        $res = $specValue
            ->where("spec_value", "=", $specVal)
            ->where("spec_id", "=", $specKeyId)
            ->find();
        if ($res != null) {
            json(["message" => "名字重复", "code" => 210, "data" => null])->send();
            exit();
        }
        $specValue->spec_value = $specVal;
        $specValue->spec_id = $specKeyId;
        $specValue->save();
    }


    public function deleteSpecKey($id)
    {
        $specKeyValue = new SpecKeyValue();
        $isExist = $specKeyValue->where(["spec_key" => $id])->find();
        if ($isExist != null) {
            json(["message" => "有商品正在使用该属性, 不能删除", "code" => 210, "data" => null])->send();
            exit();
        } else {
            $specKey = new SpecKey();
            $specKey->where(["spec_id" => $id])->delete();
            return true;
        }
    }

    public function deleteSpecValue($id)
    {
        $specKeyValue = new SpecKeyValue();
        $isExist = $specKeyValue->where(["spec_value" => $id])->find();
        if ($isExist != null) {
            json(["message" => "有商品正在使用该属性值,不能删除", "code" => 210, "data" => null])->send();
            exit();
        } else {
            $specValue = new SpecValue();
            $collection = $specValue->where(["spec_value_id" => $id])->select();
            $spec_key_id = $collection[0]["spec_id"];
            $specValue->where(["spec_value_id" => $id])->delete();
            return $spec_key_id;
        }
    }

    public function getSpecTable($goodsId)
    {
        $goodsInfoModel = new GoodsInfo();
        $goodsInfos = $goodsInfoModel->where(["goods_id" => $goodsId])->select();
        $tableArr = []; //表格数据
        $resKey = []; // 使用到的键名
        $flag = true;
        foreach ($goodsInfos as $goodsInfo) {
            $specKeyValueModel = new SpecKeyValue();
            $specKeyValues = $specKeyValueModel->where(["goods_info" => $goodsInfo["info_id"]])->select();
            $colKV = [];
            foreach ($specKeyValues as $specKV) {
                $specValueModel = new SpecValue();
                $specValue = $specValueModel->where(["spec_value_id" => $specKV["spec_value"]])->find();
                array_push($colKV, ["id" => $specKV["spec_value"], "name" => $specValue["spec_value"]]);
                if ($flag) {
                    $specKeyModel = new SpecKey();
                    $specKey = $specKeyModel->where(["spec_id" => $specValue["spec_id"]])->find();
                    array_push($resKey, $specKey);
                }
            }
            $flag = false;
            array_push($colKV, [
                "price" => $goodsInfo["goods_price"],
                "stock" => $goodsInfo["goods_stock"],
                "info_id" => $goodsInfo["info_id"]
            ]);
            array_push($tableArr, $colKV);
        }

//        if (count($tableArr) > 0) {
//            foreach ($tableArr[0] as $item) {
//                $specKeyModel = new SpecKey();
//                $specKey = $specKeyModel->where(["spec_id" => $item[]])->find();
//                array_push($resKey, $specKey);
//            }
//        }

        return ["tableArr" => $tableArr, "resKey" => $resKey];
    }

    public function getSpecKvInfoByGoodsId($goodsId)
    {
        $goodsInfo = new GoodsInfo();
        $specKeyValue = new SpecKeyValue();
        $goodsInfos = $goodsInfo->where(["goods_id" => $goodsId])->select();


        $specList = [];
        $skuList = [];
        $flag = true;
        foreach ($goodsInfos as $goodsInfo) {
            $select = $specKeyValue->where(["goods_info" => $goodsInfo["info_id"]])->select();

            if ($flag) {
                foreach ($select->toArray() as $item) {
                    $specKeyModel = new SpecKey();
                    $specKey = $specKeyModel->where(["spec_id" => $item["spec_key"]])->find();
                    array_push($specList, [
                        "id" => $item["spec_key"],
                        "title" => $specKey["spec_name"],
                        "list" => []
                    ]);
                }
                $flag = false;
            }
            $skuTmp = [];
            for ($index = 0; $index < count($select); $index++) {
                $specValueModel = new SpecValue();
                $specValue = $specValueModel->where(["spec_value_id" => $select[$index]["spec_value"]])->find();
                $tmp = ["id" => $specValue["spec_value_id"], "content" => $specValue["spec_value"]];
                array_push($skuTmp, $tmp);
                if (!in_array($tmp, $specList[$index]["list"], true)) {
                    array_push($specList[$index]["list"], $tmp);
                }
//                array_push($skuList[$index]["specs"], $tmp);
            }
            array_push($skuList, ["id" => $goodsInfo["info_id"], "specs" => $skuTmp]);
            // 混合
        }
        return ["specList" => $specList, "skuList" => $skuList];
    }


    public function getSpecKvByInfoId($id)
    {
        $specKeyValueModel = new SpecKeyValue();
        $specKeyValues = $specKeyValueModel->where(["goods_info" => $id])->select();
        $arr = [];
        foreach ($specKeyValues as $specKv) {
            $specKeyModel = new SpecKey();
            $specValueModel = new SpecValue();
            $specKey = $specKeyModel->where(["spec_id" => $specKv["spec_key"]])->find();
            $specValue = $specValueModel->where(["spec_value_id" => $specKv["spec_value"]])->find();
            array_push($arr, ["key" => $specKey, "value" => $specValue]);
        }

        return $arr;

    }


}