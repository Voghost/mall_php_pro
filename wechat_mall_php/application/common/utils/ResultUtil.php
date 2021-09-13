<?php

namespace app\common\utils;

class ResultUtil
{
    static function OK($data)
    {
        return json(["message" => $data, "meta" => ["code" => 200, "msg" => "ok"]]);
    }
}