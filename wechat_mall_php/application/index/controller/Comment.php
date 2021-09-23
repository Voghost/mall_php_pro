<?php

namespace app\index\controller;

use app\common\utils\ResultUtil;
use think\App;
use think\Controller;

class Comment extends Controller
{

    private $commentService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->commentService = \think\facade\App::model("comment", "service", true);
    }

    public function commentList()
    {
        $allComment = $this->commentService->getAllComment();
        return ResultUtil::OK($allComment);
    }

    public function pageSearch($page = null, $limit = null, $goods_id = null)
    {
        if ($page != null && $limit != null && $goods_id != null) {
            $pageSearch = $this->commentService->pageSearch($page, $limit, $goods_id);
            return ResultUtil::OK($pageSearch);
        } else {
            return ResultUtil::FAIL();
        }
    }

    public function addComment()
    {
        $query = $this->request->post();
        $temp = $this->commentService->addComment($query);
        return ResultUtil::OK($temp);
    }
}
