<?php

namespace app\wechat\controller;


use think\App;
use think\Controller;
use think\Db;

class Home extends Controller
{
    private $homeService;


    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->homeService = \think\facade\App::model("home", "service", true);
    }


    public function swiperdata()
    {
        return $this->homeService->swiperList();
    }


    public function catitems()
    {
        $map1 = array("name" => "分类", "image_src" => "https://oss.ghovos.top/wechat-mini/public/icon_index_nav_4%402x.png", "open_type" => "switchTab", "navigator_url" => "/pages/category/index");
        $map2 = array("name" => "秒拍杀", "image_src" => "https://oss.ghovos.top/wechat-mini/public/icon_index_nav_3%402x.png");
        $map3 = array("name" => "", "image_src" => "https://oss.ghovos.top/wechat-mini/public/icon_index_nav_2%402x.png");
        $map4 = array("name" => "秒拍杀", "image_src" => "https://oss.ghovos.top/wechat-mini/public/icon_index_nav_1%402x.png");
        $messageList = array("map1" => $map1, "map2" => $map2, "map3" => $map3, "map4" => $map4);
        return json(["message" => $messageList, "meta" => ["msg" => "获取成功", "status" => 200]]);
    }


    public function floordata()
    {
        $floorList = $this->homeService->floorList();
        return json(["meta" => ["msg" => "获取成功", "status" => "200"], "message" => $floorList]);
    }
}