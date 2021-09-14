<?php

namespace app\index\controller;

use app\common\service\UploadService;
use think\Controller;
use OSS\OssClient;
use OSS\Core\OssException;

/**
 * 文件上传控制器
 * @author edgar Liu
 *
 * Class Upload
 * @package app\common\controller
 */
class Upload extends Controller
{
    /* private $uploadService;
     private $hello;

     public function setUploadService($uploadService)
     {
         $this->uploadService = $uploadService;
     }*/

    /**
     * 上传文件接口
     * @return \think\response\Json 文件url
     */
    public function file()
    {
//        $file = request()->file("file");

        $array = request()->file(); // 获取第一个文件
        $file = reset($array);
        if ($file == null) {
            return json(["message" => "获取不到文件", "code" => "201", "data" => null]);
        }
        $uploadService = new UploadService();
        $res = $uploadService->ossUpdate($file);
        if ($res == "false") {
            return json(["message" => "上传失败", "code" => 201, "data" => null]);
        } else {
            return json(["message" => "ok", "code" => 200, "data" => ["url" => $res, "name" => $file->getInfo()["name"]]]);
        }
    }

}
