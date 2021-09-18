<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Orders as OrderModel;

class Order extends Controller
{
    // 订单完成 3,  配送中 2,   已支付 1,  未支付 0
    public function page($page = null, $limit = null)
    {
        $query = $this->request->post();
        $where = array();

        if (array_key_exists("order_number", $query) && $query["order_number"] != "") {
            $where[] = ["order_number", "=", $query["order_number"]];
        }
//        if (array_key_exists("sortColumn", $query) && array_key_exists("sortType", $query)) {
//        }

        $res = OrderModel::where($where);
//        return json($query);
        $temp = null;
        if (array_key_exists("Datevalue", $query)) {
            $temp = $query["Datevalue"];
        }

        if (array_key_exists("sortColumn", $query) && array_key_exists("sortType", $query)) {
            if ($query["sortType"] == 'ascending') {
                $res->order($query["sortColumn"], 'asc');
            } else {
                $res->order($query["sortColumn"], 'desc');
            }
        }

        if($temp != null){
            $count = $res->whereBetweenTime("order_create_time",$temp[0],$temp[1])->count();
            $res = $res->page($page, $limit)->whereBetweenTime("order_create_time",$temp[0],$temp[1])->select();
        } else {
            $res = $res->page($page, $limit)->select();
            $count = OrderModel::where($where)->count();
        }

        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => [
                    "page" => $page,
                    "total" => $count,
                    "content" => $res
                ]
            ]
        );
    }

    public function updateState($id, $state)
    {
        if ($id != null && $state != null) {
            $order = OrderModel::where("order_id", $id)->find();
            if ($order == null) {
                return \json(['message' => '修改失败', "code" => 201, 'data' => null]);
            }
            $order->order_state = $state;
            $order->save();
            return \json(['message' => 'ok', "code" => 200, 'data' => $order]);
        } else {
            return \json(['message' => '参数错误', "code" => 201, 'data' => null]);
        }

    }

}