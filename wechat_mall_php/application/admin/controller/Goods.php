<?php

namespace app\admin\controller;

use app\common\model\ImageUrl;
use app\common\service\GoodsService;
use app\common\model\Category;
use app\common\utils\ResultUtil;
use think\App;
use think\Controller;
use app\common\model\Goods as GoodsModel;
use app\common\model\Category as CategoryModel;
use think\response\Json;

class Goods extends Controller
{

    private $goodsService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->goodsService = \think\facade\App::model("goods", "service", true);
    }

    /**
     * 获取所有商品
     * @return Json
     */
    public function all()
    {
        $query = GoodsModel::all();
        return json($query);
    }

    /**
     * 分页查询
     * @return Json
     */
    public function page($page = null, $limit = null)
    {
        $query = $this->request->post();
        $pageSearch = $this->goodsService->pageSearch($page, $limit, $query);
        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => $pageSearch
            ]
        );
    }


    /**
     * 更新商品信息
     */
    public function saveOrUpdate()
    {
        $query = $this->request->put();
        $count = 0;
        if (!array_key_exists("goodsId", $query) || $query["goodsId"] == "") {
            $goods = new GoodsModel();
            $goods->goods_add_time = date('Y-m-d H:i:s');
        } else {
            $goods = GoodsModel::where("goods_id", $query["goodsId"])->find();
        }

        if (array_key_exists("goodsName", $query) && $query['goodsName'] != "") {
            $goods->goods_name = $query['goodsName'];
            $count++;
        }
        if (array_key_exists("goodsPrice", $query)) {
            $goods->goods_price = $query['goodsPrice'];
            $count++;
        }
        if (array_key_exists("goodsNumber", $query)) {
            $goods->goods_number = $query['goodsNumber'];
            $count++;
        }
        if (array_key_exists("goodsWeight", $query)) {
            $goods->goods_weight = $query['goodsWeight'];
            $count++;
        }
        if (array_key_exists("goodsIntroduce", $query)) {
            $goods->goods_introduce = $query['goodsIntroduce'];
            $count++;
        }
        if (array_key_exists("goodsBigLogo", $query)) {
            $goods->goods_big_logo = $query['goodsBigLogo'];
            $goods->goods_small_logo = $query['goodsBigLogo'];
            $count++;
        }
        if (array_key_exists("goodsState", $query)) {
            $goods->goods_state = $query['goodsState'];
            $count++;
        }
        if (array_key_exists("goodsCatThreeId", $query)) {
            $goods->goods_cat_three_id = $query['goodsCatThreeId'];
            $categoryThree = CategoryModel::get($query['goodsCatThreeId']);
            $categoryTwo = CategoryModel::get($categoryThree->cat_pid);
            $categoryOne = CategoryModel::get($categoryTwo->cat_pid);
            $goods->goods_cat_two_id = $categoryTwo->cat_id;
            $goods->goods_cat_one_id = $categoryOne->cat_id;
            $count++;

        }
        if (array_key_exists("goodsPicOne", $query)) {
            $goods->goods_pic_one = $query['goodsPicOne'];
            $count++;
        }
        if (array_key_exists("goodsPicTwo", $query)) {
            $goods->goods_pic_two = $query['goodsPicTwo'];
            $count++;
        }
        if (array_key_exists("goodsPicThree", $query)) {
            $goods->goods_pic_three = $query['goodsPicThree'];
            $count++;
        }
        // 如果有数据修改或添加
        if ($count > 0) {
            $goods->goods_upd_time = date('Y-m-d H:i:s');
            $goods->save();
        }
        return \json(['message' => 'ok', "code" => 200, 'data' => $goods]);
    }

    public function getCategory($level, $catId)
    {
        if ($level != null && $catId != null) {
            $categories = CategoryModel::where("cat_pid", $catId)->where("cat_level", $level)->select();
            return \json(['message' => 'ok', "code" => 200, 'data' => $categories]);
        } else {
            return \json(['message' => '参数错误', "code" => 200, 'data' => null]);
        }
    }

    public function deletePic($id)
    {
        if ($id != null && $id != '') {
            $imageUrl = new ImageUrl();
            $imageUrl->where(["id" => $id])->delete();
        }
        return json(['message' => 'ok', "code" => 200, "data" => null]);
    }
}
