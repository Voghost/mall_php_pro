<?php

namespace app\admin\controller;

use app\common\model\Logistics;
use DateTime;
use think\Controller;
use app\common\model\Orders as OrderModel;
use app\common\model\Logistics as LogisticsModel;

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

        if (array_key_exists("order_state", $query) && $query["order_state"] != 0) {
            if($query["order_state"] == 1) {
                $where[] = ["order_state", "=", 0];
                $where[] = ["order_refund", "=", 0];
            } else if($query["order_state"] == 2) {
                $where[] = ["order_state", "=", 1];
                $where[] = ["order_refund", "=", 0];
            } else if($query["order_state"] == 3) {
                $where[] = ["order_state", "=", 2];
                $where[] = ["order_refund", "=", 0];
            } else if($query["order_state"] == 4) {
                $where[] = ["order_refund", "=", 1];
            } else if($query["order_state"] == 5) {
                $where[] = ["order_refund", "=", 2];
            } else if($query["order_state"] == 6) {
                $where[] = ["order_state", "=", 3];
                $where[] = ["order_refund", "=", 0];
            }
        }

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

        for($i = 0;$i < count($res);$i++) {
            $temp = $res[$i];
            $loglist = LogisticsModel::where("order_id", $temp["order_id"])->column("content");
            $logtime = LogisticsModel::where("order_id", $temp["order_id"])->column("time");
//            $count = count($loglist) - 1;
            $logList = array();
            for($j = 0;$j < count($logtime);$j++) {
                array_push($logList,["time"=>$logtime[$j],"content"=>$loglist[$j]]);
            }
            $latest = end($loglist);
            $res[$i]["loglist"] = $logList;
//            $res[$i]["logtime"] = $logtime;
            $res[$i]["latest"] = $latest;
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

    public function refund($id, $content)
    {
        $order = OrderModel::where("order_id", $id)->find();
        $order->order_refund = 1;
        $order->save();
        $log = new Logistics();
        $log["order_id"] = $order->order_id;
        $log["content"] = $content;
        $log["status"] = 0;
        $dt = new DateTime();
        $log["time"] = $dt->format('Y-m-d H:i:s');
        $log->save();
        return json(["message"=>"正在申请退款","code"=>200]);
    }

    public function finishOrder($id)
    {
        $order = OrderModel::where("order_id", $id)->find();
        $order->order_state = 3;
        $order->save();
        return json(["message"=>"订单完成","code"=>200]);
    }

    public function updateState($id, $state)
    {
        if ($id != null && $state != null) {
            $order = OrderModel::where("order_id", $id)->find();

            if ($order == null) {
                return \json(['message' => '修改失败', "code" => 201, 'data' => $id]);
            }
            $query = $this->request->post();
            if($query != null){
                $order->order_state = $state;
            }
            if($state == 2 && $query != null) {
                $log = new Logistics();
                $log["order_id"] = $order->order_id;
                $count = LogisticsModel::where("order_id",$order->order_id)->count();
                $log["status"] = $count + 1;
                $log["content"] = $query["logis"];
                $dt = new DateTime();
                $log["time"] = $dt->format('Y-m-d H:i:s');
                $log->save();
            } elseif ($query == null) {
                $order->order_refund = $state;
            }
            $order->save();
            return \json(['message' => 'ok', "code" => 200, 'data' => $order]);
        } else {
            return \json(['message' => '参数错误', "code" => 201, 'data' => null]);
        }

    }

}