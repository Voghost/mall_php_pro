<?php


namespace app\index\controller;


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
        $user=$this->checkUser();
        return $this->CartService->addCartItem($map,$user);
    }
    public function all(){
        $userTemp=$this->checkUser();
        //return $this->CartService->allCartItem($userTemp);
        //测试用
        return $this->CartService->allCartItem();
    }
    public function changeNumber($id,$number){
        if ($id != null && $id != '') {
            $cart=new CartModel();
            $cart->where(['id'=>$id])->update(['number'=>$number]);
        }
        return ResultUtil::OK("修改成功");
    }
    public function deleteCartItem($id){
        if ($id != null && $id != '') {
            $cart =new CartModel();
            $cart->where(['id'=>$id])->delete();

        }
        return ResultUtil::OK("删除成功");
    }
    //查询用户
    private function checkUser(){
        $token = $this->request->header('Authorization');
        // 查询是否存在用户
        $userTemp = UsersModel::where("user_token", $token)->find();
        if($userTemp == null){
            json(["message" => "未找到用户","token" => $token])->send();
            exit;
        } else {
            return $userTemp;
        }
    }

}