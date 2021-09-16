<?php


namespace app\admin\controller;


use think\App;
use think\Controller;
use app\common\model\Comment as CommentModel;
use think\Db;
use think\response\Json;

class Comment extends Controller
{

    private $commentService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->commentService = \think\facade\App::model("comment","service",true);
    }

    /**
     * 分页查询
     * @return Json
     */
    public function page($page = null, $limit = null)
    {
        $query = $this->request->post();
        $pageSearch = $this->commentService->pageSearch($page, $limit, $query);
        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => $pageSearch
            ]
        );
    }

    public function getAllComment()
    {
        $commentlist1 = $this->commentService->getAllComment();
        $commentlist2 = $this->commentService->getAllCommentWithGoods($commentlist1);
//        $commentlist3 = $this->commentService->getAllCommentWithGoodsAndOrders($commentlist2,$commentlist1);
        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => $commentlist2
            ]
        );
    }

    public function getGoodsAndOrder()
    {
        $where = $this->request->put();
        $temp = $this->commentService->getGoodsAndOrder($where);
        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => $temp
            ]
        );
    }

    public function updateCommentStatus()
    {
        $query = $this->request->put();
        $where = $query["id"];
        $temp = CommentModel::where("id",$where)->find();
        if($temp['status'] == 0){
            $temp->status = 1;
        }else{
            $temp->status = 0;
        }
        $temp->save();
        return json(
            ["message" => "ok",
                "code" => 200,
                "data" => $temp
            ]
        );
    }
}