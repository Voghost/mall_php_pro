<?php

namespace app\index\controller;

use app\common\utils\ResultUtil;
use think\App;
use think\Controller;

class Home extends Controller
{
    private $homeService;
    private $goodsService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->homeService = \think\facade\App::model("home", "service", true);
        $this->goodsService = \think\facade\App::model("home", "service", true);
    }

    public function floorList()
    {
        $floorList = $this->homeService->floorList();
        return ResultUtil::OK($floorList);
    }

    public function swiperList()
    {
        return $this->homeService->swiperList();
    }

}