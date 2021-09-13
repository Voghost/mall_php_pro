<?php

namespace app\common\service;

use app\common\model\Goods as GoodsModel;
use app\common\model\Orders as OrdersModel;
use think\Db;
use think\Model;

class OrderService
{
    /**
     * @param $postMap
     * @param $user
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function createOrder($postMap, $user)
    {
        $goods = $postMap["goods"];

        $totalPrice = 0;

        $orders = new OrdersModel;
        if ($postMap["consignee_addr"] != null) {
            $temp = $postMap["consignee_addr"];
            $userName = $temp["userName"];
            $telNumber = $temp["telNumber"];
            $postalCode = $temp["postalCode"];
            $provinceName = $temp["provinceName"];
            $cityName = $temp["cityName"];
            $countyName = $temp["countyName"];
            $detailInfo = $temp["detailInfo"];
            $address = $provinceName . $cityName . $countyName . $detailInfo . $userName . "电话:" . $telNumber . "邮政编码:" . $postalCode;
            $orders["order_address"] = $address;
        }
        $orders->order_user_id = $user["user_id"];
        $orders->order_number = "Order" . time() . mt_rand(100, 999);
        $dateFormat = date('Y-m-d H:i:s');
        $orders->order_create_time = $dateFormat;
        $orders->order_update_time = $dateFormat;
        $orders->save(); //先保存要提交的order

        for ($j = 0; $j < count($goods); $j++) {
            $temp = $goods[$j];
            $orders->goods()->save($temp["goods_id"]);

            $tempGoods = GoodsModel::where("goods_id", $temp["goods_id"])->find();
            $leftNumber = $tempGoods["goods_number"] - $temp["goods_number"];
            if ($leftNumber < 0) {
                return json(["message" => ["meta" => ["msg" => "商品库存不够, 名字 " . $tempGoods["goods_name"] . "", "code" => 400]]]);
            } else if ($leftNumber == 0) {
                $tempGoods->goods_state = 1;
            }
            $tempGoods->gooods_number = $leftNumber;
            $orders->order_goods_number = $temp["goods_number"];
            $ordersGoodsList[] = $orders;
            $totalPrice = $totalPrice + ($temp["goods_number"] * $tempGoods["goods_price"]);
            $tempGoods->save();

            // 设置关联表的额外属性 (设置与1号商品关联的中间表的属性)
            $orders->goods()->attach($temp["goods_id"], ["order_goods_number" => $temp["goods_number"], "order_price" => $tempGoods["goods_price"]]);
        }

        $orders->order_user_id = $user->user_id;
        $orders->order_price = $totalPrice;
        $orders->save();


        return json(["message" => [
            "order_id" => $orders->order_id,
            "user_id" => $orders->order_user_id,
            "order_number" => $orders->order_number,
            "order_price" => $orders->order_price,
            "create_time" => strtotime($orders->order_create_time),
            "update_time" => strtotime($orders->order_update_time),
            "meta" => [
                "msg" => "创建订单成功",
                "status" => 200
            ]]]);
    }


    public function allOrder($type, $userTemp)
    {
        $userId = $userTemp->user_id;

        $where["order_user_id"] = [$userId];
        if ($type != null) {
            $where["order_state"] = [$type];
        }
        $ordersList = \app\public_common\model\Orders::where($where)->select();
        if ($ordersList == null) {
            return json([
                "message" => [
                    "total" => 0,
                    "orders" => null
                ],
                "meta" => [
                    "msg" => "获取订单列表成功",
                    "status" => 200
                ]
            ]);
        }

        $ordersResult = array();
        for ($i = 0; $i < count($ordersList); $i++) {
            $temp = array(
                "order_id" => $ordersList[$i]->order_id,
                "user_id" => $ordersList[$i]->order_user_id,
                "order_number" => $ordersList[$i]->order_number,
                "order_price" => $ordersList[$i]->order_price,
                "consignee_addr" => $ordersList[$i]->order_address,
                "create_time" => strtotime($ordersList[$i]->order_create_time),
                "update_time" => strtotime($ordersList[$i]->order_update_time)
            );

            $goods = DB::name("orders_goods")->where("order_id", $ordersList[$i]->order_id)->select();

            $goodsResult = array();
            $totalPrice = 0;
            for ($j = 0; $j < count($goods); $j++) {
                $tmp = $goods[$j];
                $mygoods = DB::name("goods")->where("goods_id", $tmp["order_goods_id"])->find();
                $goodsTemp = array(
                    "goods_id" => $mygoods["goods_id"],
                    "order_id" => $ordersList[$i]->order_id,
                    "goods_price" => $tmp["order_price"],
                    "goods_number" => $tmp["order_goods_number"],
                    "goods_total_price" => $tmp["order_goods_number"] * $tmp["order_price"],
                    "goods_name" => $mygoods["goods_name"],
                    "goods_small_logo" => $mygoods["goods_small_logo"]
                );
                $goodsResult[] = $goodsTemp;
                $totalPrice = $totalPrice + $tmp["order_goods_number"] * $tmp["order_price"];
            }
            $temp["goods"] = $goodsResult;
            $temp["total_count"] = count($goodsResult);
            $temp["total_price"] = $totalPrice;
            $ordersResult[] = $temp;
        }

        return json([
            "message" => [
                "count" => count($ordersResult),
                "orders" => $ordersResult
            ],
            "meta" => [
                "msg" => "获取订单列表成功",
                "status" => 200
            ]
        ]);
    }

}