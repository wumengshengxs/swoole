<?php


/**
 * 代表的是 swoole里面的所有task异步任务
 */
namespace app\common\lib\task;

use app\common\lib\ali\Sms;
use app\common\lib\Redis;
use app\common\lib\redis\Predis;

class Task
{
    /**
     * 异步发送验证码
     * @param $param
     * @return bool
     */
    public function sendSms($param)
    {
        try {
            $data = Sms::SendSms($param['phone'],$param['code']);

            if ($data['status'] == 200 && $data['msg']['Message'] == 'OK'){
                //如果发送成功把验证码记录到redis里面
                Predis::getInstance()->set(Redis::smsKey($param['phone']),$param['code'],config('redis.out_time'));
            }else{
                return false;
            }

        }catch (\Exception $e){
            echo $e->getMessage();
        }

    }

}