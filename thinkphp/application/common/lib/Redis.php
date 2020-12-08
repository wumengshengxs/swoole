<?php

namespace app\common\lib;

class Redis
{
    //验证码前缀
    public static $pre = "sms_";
    //用户信息前缀
    public static $userPre = "user_";

    /**
     * 存储验证码 redis key
     * @param $phone
     * @return string
     */
    public static function smsKey($phone)
    {
        return self::$pre.$phone;
    }

    /**
     * 储存用户信息 reids key
     * @param $phone
     * @return string
     */
    public static function userKey($phone)
    {
        return self::$userPre.$phone;

    }


}










