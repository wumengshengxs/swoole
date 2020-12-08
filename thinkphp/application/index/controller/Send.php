<?php


namespace app\index\controller;


use app\common\lib\ali\Sms;
use app\common\lib\Redis;
use app\common\lib\Util;
use think\Controller;

class Send extends Controller
{

    /**
     * 验证码
     */
    public function index()
    {
        try {
            $phone = request()->get('phone_num',0);

            if (empty($phone)) {
                return Util::show(config('code.error'),'手机号为空');
            }

            $code = mt_rand(100000,999999);
            $taskData = [
                'method'=>'sendSms',
                'data'=>[
                    'phone' => $phone,
                    'code'  => $code
                ]
            ];
            $_POST['http_server']->task($taskData);

            return Util::show(config('code.success'),'发送成功');
//            if ($data['status'] == 200 && $data['msg']['Message'] == 'OK'){
//                //异步redis
//                $redisClient = new \Swoole\redis();
//                $redisClient->connect(config('redis.host'),config('redis.port'),function (\Swoole\redis $redisClient, $result) use($phone, $code){
//                    //异步
//                    $redisClient->set(Redis::smsKey($phone),$code, function (\Swoole\redis $redisClient, $result){
//                        //回调
//                    });
//                });
////                return Util::show(config('code.success'),'发送失败');
//            }else{
//                return Util::show(config('code.error'),'发送失败');
//            }
        }catch(\Exception $e){
            //todo
            return Util::show(config('code.error'),'网络链接失败');
        }
    }

}