<?php

namespace app\common\service;
use app\admin\controller\Goods;
use app\common\model\Cart;
use app\common\model\Cart as CartModel;
use app\common\model\Goods as GoodsModel;
use think\Db;
use app\common\utils\ResultUtil;
use mysql_xdevapi\Result;
use think\Model;

class CartService
{

    public function addCartItem($goods,$user){
        $cart=new CartModel;
        $cart->goods_info_id=$goods['info_id'];
        $dateFormat=date('Y-m-d H:i:s');
        $cart->add_time=$dateFormat;
        $cart->user_id=$user['user_id'];
        $cart->number=$goods['number'];
        $cart->save();
        return json(["message"=>[
            "id"=>$cart->id,
            "good_info_id"=>$cart->goods_info_id,
            "add_time"=>strtotime($cart->add_time),
            "user_id"=>$cart->user_id,
            "number"=>$cart->number,
            "meta"=>[
                "msg"=>"添加到购物车成功",
                "status"=>200
            ]
        ]]);

    }
    public function allCartItem(){
        //$userId=$userTemp->user_id;
        $userId=18;
        $cart = new CartModel();
        $cartList= $cart->where(['user_id'=>$userId])->select();
        if($cartList==null){
           return ResultUtil::FAIL();
        }
        $cartResult=array();
        // goods_info_id->goods_id->goods->info
        for($i=0;$i<count($cartList);$i++){
            $temp=array(
                "id"=>$cartList[$i]->id,
              //  "goods_info_id"=>$cartList[$i]->goods_info_id,
              //  "add_time"=>$cartList[$i]->add_time,
                "user_id"=>$cartList[$i]->user_id,
                "number"=>$cartList[$i]->number,
            );
            $goods=new GoodsModel();
            $goodsInfoResult=DB::name("goods_info")->where("info_id",$cartList[$i]->goods_info_id)->select();
            $goodsResult=$goods->where("goods_id",$goodsInfoResult[0]['goods_id'])->select();
            $temp['price']=$goodsInfoResult[0]['goods_price'];
            $temp['total']=$goodsInfoResult[0]['goods_price']*$temp['number'];
            $temp['goods_id']=$goodsResult[0]['goods_id'];
            $temp['goods_name']=$goodsResult[0]['goods_name'];
            $temp['goods_big_logo']=$goodsResult[0]['goods_big_logo'];
            //$temp['goods_info']=$goodsInfoResult;
            //$temp['goods']=$goodsResult;
            $cartResult[]=$temp;
        }
        return ResultUtil::OK($cartResult);
    }
    public function showConfirmCartItem($data){
        if($data==null){
            return ResultUtil::FAIL();
        }

        //$userId=$userTemp->user_id;
        $userId=18;
        $cart = new CartModel();
        $cartList= $cart->where(['user_id'=>$userId])->where('id','in',$data)->select();
        if($cartList==null){
            return ResultUtil::FAIL();
        }
        $cartResult=array();
        // goods_info_id->goods_id->goods->info
        for($i=0;$i<count($cartList);$i++){
            $temp=array(
                "id"=>$cartList[$i]->id,
                //  "goods_info_id"=>$cartList[$i]->goods_info_id,
                //  "add_time"=>$cartList[$i]->add_time,
                "user_id"=>$cartList[$i]->user_id,
                "number"=>$cartList[$i]->number,
            );
            $goods=new GoodsModel();
            $goodsInfoResult=DB::name("goods_info")->where("info_id",$cartList[$i]->goods_info_id)->select();
            $goodsResult=$goods->where("goods_id",$goodsInfoResult[0]['goods_id'])->select();
            $temp['price']=$goodsInfoResult[0]['goods_price'];
            $temp['total']=$goodsInfoResult[0]['goods_price']*$temp['number'];
            $temp['goods_name']=$goodsResult[0]['goods_name'];
            $temp['goods_big_logo']=$goodsResult[0]['goods_big_logo'];
            //$temp['goods_info']=$goodsInfoResult;
            //$temp['goods']=$goodsResult;
            $cartResult[]=$temp;
        }
        return ResultUtil::OK($cartResult);
    }

}