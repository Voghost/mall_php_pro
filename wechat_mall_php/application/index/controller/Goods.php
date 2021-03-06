<?php

namespace app\index\controller;

use app\common\model\ImageUrl as ImageUrlModel;
use app\common\model\Comment as CommentModel;
use app\common\model\Users as UserModel;
use app\common\utils\ResultUtil;
use think\App;
use think\Controller;

class Goods extends Controller
{
    private $goodsService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->goodsService = \think\facade\App::model("goods", "service", true);
    }

    public function categoriesList()
    {
        $allCategories = $this->goodsService->getAllCategories();
        return ResultUtil::OK($allCategories);
    }
    public function detail($goods_id)
    {
        $goodsDetail = $this->goodsService->goodsDetail($goods_id);
        return ResultUtil::OK($goodsDetail);
    }

    public function search($query = '', $cat_id = '')
    {
        $search = $this->goodsService->search($query, $cat_id);
        $res = [];
        for ($i = 0; $i < count($search); $i++) {
            array_push($res, ["value" => $search[$i]["goods_name"], "id" => $search[$i]["goods_id"]]);
        }
        return ResultUtil::OK($res);
    }

    public function pageSearch($page = null, $limit = null)
    {
        $query = $this->request->post();
        $pageSearch = $this->goodsService->pageSearch($page, $limit, $query, true);
        return ResultUtil::OK($pageSearch);
    }

    public function goodsDetail($id = null)
    {
        $goodsDetail = $this->goodsService->goodsDetail($id);
        $imageUrlModel = new ImageUrlModel();
        $imageUrls = $imageUrlModel->where(["from" => 1, "f_id" => $goodsDetail["goods_id"]])->select();
        $pics = [];
//        $commentlist = CommentModel::where("goods_id",$id)->select();
//        for($i = 0;$i < count($commentlist);$i++){
//            $temp = UserModel::where("user_id",$commentlist[$i]["user_id"])->column("user_name");
//            $commentlist[$i]["user_name"] = $temp[0];
//        }
//        $goodsDetail["comment"] = $commentlist;
        foreach ($imageUrls as $image) {

            array_push($pics, $image["url"]);
        }
        $goodsDetail["pic"] = $pics;
        return ResultUtil::OK($goodsDetail);
    }
}
