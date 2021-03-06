<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');


// 支持跨域请求
\think\facade\Route::post('upload/file', "index/upload/file")
    ->allowCrossDomain();


// admin 路由 且拥有 admin 和 user 权限
\think\facade\Route::group("admin", [
    'goods/all' => 'admin/goods/all',
    'goods/page' => 'admin/goods/page',
    'goods/saveOrUpdate' => 'admin/goods/saveOrUpdate',
    'goods/getCategory' => 'admin/goods/getCategory',
    'goods/deletePic' => 'admin/goods/deletePic',
    'goods/getCommentWithOrder' => 'admin/goods/getCommentWithOrder',
    'echart/getSearch' => 'admin/echart/getSearch',
    'echart/getWeekData' => 'admin/echart/getWeekData',
    'echart/getTenOrder' => 'admin/echart/getTenOrder',
    'echart/getTenComment' => 'admin/echart/getTenComment',
    'home/allSwiper' => 'admin/home/allSwiper',
    'home/allFloor' => 'admin/home/allFloor',
    'home/deleteSwiper' => 'admin/home/deleteSwiper',
    'home/deleteFloor' => 'admin/home/deleteFloor',
    'home/updateSwiper' => 'admin/home/saveOrUpdateSwiper',
    'home/updateFloor' => 'admin/home/saveOrUpdateFloor',
    'home/saveOrUpdateSwiper' => 'admin/home/saveOrUpdateSwiper',
    'home/saveOrUpdateFloor' => 'admin/home/saveOrUpdateFloor',
    'category/getCategory' => 'admin/category/getCategory',
    'category/updateState' => 'admin/category/updateState',
    'category/saveOrUpdate' => 'admin/category/saveOrUpdate',
    'order/page' => 'admin/order/page',
    'order/updateState' => 'admin/order/updateState',
    'user/all' => 'admin/my_user/all',
    'user/logout' => 'admin/my_user/logout',
    'comment/page' => 'admin/comment/page',
    'comment/getGoodsAndOrder' => 'admin/comment/getGoodsAndOrder',
    'comment/updateCommentStatus' => 'admin/comment/updateCommentStatus',
    'spec/allKey' => 'admin/spec/allKey',
    'spec/getSpecKeyByIds' => 'admin/spec/getSpecKeyByIds',
    'spec/specTree' => 'admin/spec/specTree',
    'spec/addSpecKey' => 'admin/spec/addSpecKey',
    'spec/addSpecValue' => 'admin/spec/addSpecValue',
    'spec/deleteSpecKey' => 'admin/spec/deleteSpecKey',
    'spec/deleteSpecValue' => 'admin/spec/deleteSpecValue',
    'spec/getSpecTableAndKV' => 'admin/spec/getSpecTableAndKv',
])
    ->allowCrossDomain()
    ->middleware('VerifyMyUser')
    ->middleware(Auth::class, ["ADMIN", "USER"]);


// admin 路由 且拥有 admin 和 user 权限
\think\facade\Route::group("admin", [
    'users/page' => 'admin/user/page',
    'users/updateState' => 'admin/user/updateState',
    'admin/page' => 'admin/admin/page',
    'admin/saveAdmin' => 'admin/admin/saveAdmin',
    'admin/getRole' => 'admin/admin/getRole',
    'admin/addRole' => 'admin/admin/addRole',
    'admin/deleteRole' => 'admin/admin/deleteRole'
])
    ->allowCrossDomain()
    ->middleware('VerifyMyUser')
    ->middleware(Auth::class, ["ADMIN"]);


// admin 要路由 无权限
\think\facade\Route::get("admin/user/info", "admin/my_user/info")
    ->allowCrossDomain()
    ->middleware("VerifyMyUser");


\think\facade\Route::post("admin/user/login", "admin/my_user/login")
    ->allowCrossDomain();

\think\facade\Route::get("wechat/goods/categories", "wechat/goods/categories")->allowCrossDomain();
\think\facade\Route::get("wechat/home/floordata", "wechat/home/floordata")->allowCrossDomain();
return [

];
