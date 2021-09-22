<?php


namespace app\index\controller;

use app\common\model\UserAddress as AddressModel;
use app\common\model\Users as UserModel;
use think\Controller;

class Address extends Controller
{

    public function all()
    {
        $query = AddressModel::all();
        return json($query);
    }

    public function getById($id) {
        $list= AddressModel::where("user_id", $id)->select();
        return json(["message"=>"获取成功","code"=>200,"data"=>$list]);
    }
    public function getUsernameById($id){
        $username=UserModel::where("user_id",$id)->value("user_name");
        return json(["message"=>"获取成功","code"=>200,"data"=>$username]);
    }

    public function delete($id) {
        AddressModel::where(["id"=>$id])->delete();
        return json(["message"=>"删除成功"]);
    }

    public function add($id) {
        $query = $this->request->post();
        $temp = new \app\common\model\UserAddress();
        $temp->address = $query["address"];
        $temp->phone = $query["phone"];
        $temp->user_id = $id;
        $temp->save();
        return json(["message"=>"添加成功"]);
    }

    public function change($id) {
        $query = $this->request->post();
        $temp = AddressModel::where("id",$id)->find();
        if(array_key_exists("address",$query)) {
            $temp->address = $query["address"];
        }
        if(array_key_exists("phone",$query)) {
            $temp->phone = $query["phone"];
        }
        $temp->save();
        return json(["message"=>"修改成功"]);
    }
}