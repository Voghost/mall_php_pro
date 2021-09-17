<?php

namespace app\common\service;

use app\admin\controller\Spec;
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

}