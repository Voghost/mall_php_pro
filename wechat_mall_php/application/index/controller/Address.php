<?php


namespace app\index\controller;

use app\common\model\UserAddress as AddressModel;
use app\common\model\Users as UserModel;
use app\common\utils\CheckUser;
use app\common\utils\ResultUtil;
use think\Controller;

class Address extends Controller
{

    public function all()
    {
        $query = AddressModel::all();
        return json($query);
    }

    public function getById()
    {
        $userTemp = CheckUser::checkUser($this->request);
        $userId = $userTemp->user_id;
        $list = AddressModel::where("user_id", $userId)->select();
        return json(["message" => "获取成功", "code" => 200, "data" => $list]);
    }

    public function getUsernameById()
    {
        $userTemp = CheckUser::checkUser($this->request);
        $userId = $userTemp->user_id;
        $username = UserModel::where("user_id", $userId)->value("user_name");
        return json(["message" => "获取成功", "code" => 200, "data" => $username]);
    }

    public function delete($id)
    {
        AddressModel::where(["id" => $id])->delete();
        return json(["message" => "删除成功"]);
    }

    public function add()
    {
        $query = $this->request->post();
        $userTemp = CheckUser::checkUser($this->request);
        $userId = $userTemp->user_id;
        $temp = new \app\common\model\UserAddress();
        $temp->address = $query["address"];
        $temp->phone = $query["phone"];
        $temp->user_id = $userId;
        $temp->save();
        return json(["message" => "添加成功"]);
    }

    public function addOrUpdateAll()
    {
        $users = CheckUser::checkUser($this->request);
        $list = $this->request->post("list");
        foreach ($list as $item) {
            $userAddress = new AddressModel();
            if (array_key_exists("id", $item)) {
                $userAddress = $userAddress->where(["id" => $item["id"]])->find();
            }
            $userAddress->address = $item["address"];
            $userAddress->phone = $item["phone"];
            $userAddress->user_id = $users["user_id"];
            $userAddress->save();
        }
        return ResultUtil::OK();

    }

    public function deleteById($id)
    {
        if ($id != null) {
            $users = CheckUser::checkUser($this->request);
            $userAddressModel = new AddressModel();
            $userAddress = $userAddressModel->where(["id" => $id])->find();
            $userAddress->delete();
        }

        return ResultUtil::OK();
    }

    public function change($id)
    {
        $query = $this->request->post();
        $temp = AddressModel::where("id", $id)->find();
        if (array_key_exists("address", $query)) {
            $temp->address = $query["address"];
        }
        if (array_key_exists("phone", $query)) {
            $temp->phone = $query["phone"];
        }
        $temp->save();
        return json(["message" => "修改成功"]);
    }
}