<?php


namespace app\admin\controller;


use app\common\model\Comment as CommentModel;
use app\common\model\Orders as OrderModel;
use app\common\model\Users as UserModel;
use DateInterval;
use DateTime;
use think\Controller;
use function Sodium\add;

class Echart extends Controller
{
    public function getSearch()
    {
        $userCount = UserModel::count();
        $commentCount = CommentModel::count();
        $where[] = ["order_refund","<>",2];
        $priceTotal = OrderModel::where($where)->sum("order_price");
        $orderTotal = OrderModel::count();
        $searchObj = ["userCount"=>$userCount,"commentCount"=>$commentCount,"priceTotal"=>$priceTotal,"orderTotal"=>$orderTotal];
        return json([
            "message" => "ok",
            "code" => 200,
            "data"=>$searchObj
        ]);
    }

    public function getWeekData()
    {
        $dt = new DateTime();
        $temp = $dt->format('Y-m-d');
//        $time1 = $dt->format('Y-m-d');
//        $yt = $dt->modify('-1 days');
//        $time2 = $yt->format('Y-m-d');
        $userDay = array();
        $commentDay = array();
        $priceDay = array();
        $orderDay = array();
        $day = array();

        $timeTemp = new DateTime(1970-01-01);
        $time4 = $timeTemp->format('Y-m-d');
        $user = UserModel::count();
        $comment = CommentModel::whereBetweenTime("time",$temp)->count();
        $price = OrderModel::whereBetweenTime("order_create_time",$temp)->where("order_refund","<>",2)->sum("order_price");
        $order = OrderModel::whereBetweenTime("order_create_time",$temp)->where("order_refund","<>",2)->count();
        $time3 = $dt->format('m/d');
        array_push($userDay,$user);
        array_push($commentDay,$comment);
        array_push($priceDay,$price);
        array_push($orderDay,$order);
        array_push($day,$time3);
        for($i = 0;$i < 6;$i++) {
            $time1 = $dt->format('Y-m-d');
            $yt = $dt->modify('-1 days');
            $time2 = $yt->format('Y-m-d');
            $user = UserModel::whereBetweenTime("user_create_time",$time4,$time1)->count();
            $comment = CommentModel::whereBetweenTime("time",$time2,$time1)->count();
            $price = OrderModel::whereBetweenTime("order_create_time",$time2,$time1)->where("order_refund","<>",2)->sum("order_price");
            $order = OrderModel::whereBetweenTime("order_create_time",$time2,$time1)->where("order_refund","<>",2)->count();
            $time3 = $dt->format('m/d');
            array_push($userDay,$user);
            array_push($commentDay,$comment);
            array_push($priceDay,$price);
            array_push($orderDay,$order);
            array_push($day,$time3);
            $time1 = $time2;
            $dt = $yt;
        }

        $list[] = ["day"=>$day,"user"=>$userDay,"comment"=>$commentDay,"price"=>$priceDay,"order"=>$orderDay];
        return json([
            "message" => "ok",
            "code" => 200,
            "data"=>$list
        ]);
    }

    public function getTenOrder()
    {
        $orderlist = OrderModel::order("order_create_time","desc")->limit(10)->select();
        return json([
            "message" => "ok",
            "code" => 200,
            "data"=>$orderlist
        ]);
    }

    public function getTenComment()
    {
        $commentlist = CommentModel::order("time","desc")->limit(12)->select();
        for($i = 0;$i< 10;$i++){
            if(strlen($commentlist[$i]["content"])>10){
                $temp1 = mb_substr($commentlist[$i]["content"],0,10);
                $commentlist[$i]["content"] = $temp1."....";
            }
        }
        return json([
            "message" => "ok",
            "code" => 200,
            "data"=>$commentlist
        ]);
    }

    public function test()
    {
        $commentlist = CommentModel::order("time","desc")->limit(10)->select();
        $time1 = strlen($commentlist[4]["content"]);
        return $time1;
    }
}