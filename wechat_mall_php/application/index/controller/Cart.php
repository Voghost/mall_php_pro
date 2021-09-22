<?php


namespace app\index\controller;


use app\common\utils\CheckUser;
use app\common\utils\ResultUtil;
use think\App;
use think\Controller;
use app\common\model\Users as UsersModel;
use app\common\model\Cart as CartModel;
use think\Db;

class Cart extends Controller
{
    private $CartService;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->CartService=\think\facade\App::model("cart","service",true);
    }
    public function addItem(){
        $map=$this->request->post();
        $user=CheckUser::checkUser($this->request);
        return $this->CartService->addCartItem($map,$user);
    }
    public function all(){

        $userTemp=CheckUser::checkUser($this->request);
        return $this->CartService->allCartItem($userTemp);

    }
    //结算页面展示购买的东西
    public function showCartItem($cart_id){
        $userTemp=CheckUser::checkUser($this->request);
        $arr=[];
        $temp='';
        for($i=0;$i<strlen($cart_id);$i++){
            if(!is_numeric($cart_id[$i])){
                $arr[] = $temp;
                $temp="";
            }else{
                $temp.=$cart_id[$i];
            }
            if($i==(strlen($cart_id)-1)){
                $arr[] = $temp;
                $temp="";
            }
        }
         return $this->CartService->showConfirmCartItem($userTemp,$arr);
    }

    public function changeNumber($id,$number){
        if ($id != null && $id != '') {
            $cart=new CartModel();
            $cart->where(['id'=>$id])->update(['number'=>$number]);
        }
        return ResultUtil::OK("修改成功");
    }
    public function deleteCartItem($id){
        $userTemp=CheckUser::checkUser($this->request);
        $userId=$userTemp->user_id;
        if ($id != null && $id != '') {
            $cart =new CartModel();
            $cart->where(['id'=>$id,"user_id"=>$userId])->delete();
            return ResultUtil::OK("删除成功");
        }

    }
    //查询用户
//    private function checkUser(){
//        $token = $this->request->header('Authorization');
//        if($token!=null){
//            $userTemp = UsersModel::where("user_token", $token)->find();
//            if($userTemp == null){
//                json(["message" => "未找到用户","token" => $token])->send();
//                exit;
//            } else {
//                return $userTemp;
//            }
//        }
//        // 查询是否存在用户
//    }

}