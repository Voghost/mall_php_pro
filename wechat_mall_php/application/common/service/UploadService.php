<?php

namespace app\common\service;

use OSS\Core\OssException;
use OSS\OssClient;

class UploadService
{
    public function ossUpdate($file)
    {
        $info = $file->move("../temp/", "temp");

        $csvFile = fopen(__DIR__ . '/../../../config/mySecret.txt', "r");

        $ossKey = fgetcsv($csvFile);


        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录RAM控制台创建RAM账号。
        $accessKeyId = $ossKey[0];
        $accessKeySecret = $ossKey[1];
        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = "https://oss-cn-guangzhou.aliyuncs.com";
        // 设置存储空间名称。
        $bucket = "wechat-mall-vog";
        // 设置文件名称。
        $object = time() . mt_rand(1000, 9999) . "." . $info->getExtension();
        // <yourLocalFile>由本地文件路径加文件名包括后缀组成，例如/users/local/myfile.txt。
        $filePath = "../temp/temp." . $info->getExtension();

        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $ossClient->uploadFile($bucket, $object, $filePath);
            return "https://wechat-api.ghovos.top/" . $object;
        } catch (OssException $e) {
            return "false";
        }
    }
}