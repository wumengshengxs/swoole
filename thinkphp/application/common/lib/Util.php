<?php

namespace  app\common\lib;


class Util
{
    /**
     * ajax返回信息封装
     * @param $status
     * @param string $message
     * @param string $data
     * @return false|string
     */
    public static function show($status, $message='', $data='')
    {
        $result = [
          'status' => $status,
          'message' => $message,
          'data' => $data,
        ];

        return  json_encode($result);
    }



}