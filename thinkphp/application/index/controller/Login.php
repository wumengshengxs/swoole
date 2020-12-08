<?php

namespace app\index\controller;


use app\common\lib\redis\Predis;
use think\Controller;
use app\common\lib\Redis;
use app\common\lib\Util;

class Login extends Controller
{
    /**
     * 登录
     */
    public function index()
    {

        $phone = request()->get('phone_num',0);
        $code = request()->get('code',0);

        if (empty($phone) || empty($code)){
            return Util::show(config('code.error'), 'Phone or code is empty');
        }

        $reidsCode = Predis::getInstance()->get(Redis::smsKey($phone));

        if ($reidsCode == $code){
            //存用户信息到redis
            $data = [
                'user'=>'swoole-name',
                'phone' => $phone,
                'srcKey' => md5(Redis::userKey($phone)),
                'time' => time(),
                'isLogin' => true
            ];
            Predis::getInstance()->set(Redis::userKey($phone),$data);

            return Util::show(config('code.success'),'ok',$data);
        }else{
            return Util::show(config('code.error'),'login error');

        }

    }

}









