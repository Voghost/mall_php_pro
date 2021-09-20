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
        $saveOrUpdateGoods = $this->goodsService->saveOrUpdateGoods($query);
        return \json(['message' => 'ok', "code" => 200, 'data' => $saveOrUpdateGoods]);
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


    public function getCommentWithOrder()
    {
        $where = $this->request->put();
        $temp = $this->goodsService->getCommentWithOrder($where);
        return json([
            "message" => "ok",
            "code" => 200,
            "data" => $temp
        ]);
    }
}
