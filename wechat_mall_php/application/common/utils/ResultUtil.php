<?php

namespace app\common\utils;

class ResultUtil
{
    static function OK($data = null)
    {
        return json(["message" => $data, "meta" => ["code" => 200, "msg" => "ok"]]);
    }

    static function FAIL($data = null)
    {
        return json(["message" => null, "meta" => ["code" => 403, "msg" => "fail"]]);
    }
}