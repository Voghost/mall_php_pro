<?php


namespace app\index\controller;

use app\common\model\GoodsInfo;
use app\common\model\Orders as OrdersModel;
use app\common\model\Users as UsersModel;
use app\common\utils\JwtUtil;
use app\common\utils\ResultUtil;
use think\App;
use think\Controller;
use think\Exception;

class Order extends Controller
{
    private $orderService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->orderService = \think\facade\App::model("order", "service", true);
    }

    public function create()
    {
        $userList = $this->checkUser();

        $cartIdList = $this->request->post("ids");
        $address = $this->request->post("address");
        $cartModel = new \app\common\model\Cart();
        $map["address"] = $address;
        $map["goods"] = [];

        foreach ($cartIdList as $cartId) {
            $cart = $cartModel->where(["id" => $cartId])->find();
            $goodsInfoModel = new GoodsInfo();
            $goodsInfo = $goodsInfoModel->where(["info_id" => $cart["goods_info_id"]])->find();
            array_push($map["goods"], [
                "info_id" => $cart["goods_info_id"],
                "goods_id" => $goodsInfo["goods_id"],
                "goods_number" => $cart["number"],
            ]);

        }
        return $this->orderService->createOrder($map, $userList);
    }


    public function all($type)
    {
        $userTemp = $this->checkUser();

        if ($type == 1) {
            $type = null;
        } else {
            $type = $type - 2;
        }
        return $this->orderService->allOrder($type, $userTemp);
    }

    public function allOrder($type)
    {
        $userTemp = $this->checkUser();
        return $this->orderService->allOrder($type, $userTemp);
    }

    public function chkOrder()
    {
        $map = $this->request->post();
        // 校验用户
        $this->checkUser();
        $orders = OrdersModel::where("order_number", $map["order_number"])->find();

        if ($orders->order_state > 0) {
            return json([
                "message" => "支付成功",
                "meta" => [
                    "msg" => "验证成功",
                    "status" => 200
                ]
            ]);
        } elseif ($orders->order_state == 0) {
            return json([
                "message" => "未支付",
                "meta" => [
                    "msg" => "验证失败",
                    "status" => 400
                ]
            ]);
        }

        return json([
            "message" => null,
            "meta" => [
                "msg" => "error",
                "status" => 400
            ]
        ]);
    }

    public function pay()
    {
        $map = $this->request->post();
        // 校验用户
        $this->checkUser();

        $OrdersModel = new OrdersModel();
        $num = $OrdersModel->where("order_number", $map["order_number"])->update(['order_state' => 1]);
        if ($num > 0) {
            return json([
                "meta" => [
                    "msg" => "支付成功",
                    "code" => 200
                ],
                "message" => [
                    "pay" => 1
                ]
            ]);
        }

        return json(([
            "meta" => [
                "msg" => "支付失败",
                "code" => 200
            ],
            "message" => [
                "pay" => 0
            ]
        ]));
    }

    private function checkUser()
    {
        // 解密token
        $token = $this->request->header('Authorization');
//        try {
//            $jwtUtil = new JwtUtil();
//            $res = $jwtUtil->jwtDecode($token);
//        } catch (Exception $e) {
//            json(["message" => ["meta" => ["msg" => "error: token无效=> $e", "code" => 403]]])->send();
//            exit();
//        }

        // 查询是否存在用户
//        $userTemp = UsersModel::where("user_openid", $res["message"])->find();
        if ($token != null) {
            $userTemp = UsersModel::where("user_token", $token)->find();
            if ($userTemp == null) {
                json(["message" => "未找到用户", "token" => $token])->send();
                exit;
            } else {
//            json(["message" => "已找到用户"])->send();
                return $userTemp;
            }
        }
        json(["message" => "未找到用户", "token" => $token])->send();
        exit;
//        if ($userTemp == null || $userTemp["user_id"] == null || $userTemp["user_is_active"] == false) {
//            json(["message" => ["meta" => ["msg" => "error: 鉴权失败", "code" => 403]]])->send();
//            exit();
//        } else {
//            return $userTemp;
//        }
    }
}