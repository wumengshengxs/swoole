<?php
namespace app\common\lib\redis;


class Predis
{
    /**
     * 定义单例模式的变量
     */
    private static $_instance = null;

    public $redis;

    /**
     * 单例模式访问
     * @return Predis|null
     * @throws \Exception
     */
    public static function getInstance()
    {
        $db = empty(self::$_instance) ? new self() : self::$_instance;

        return $db;
    }

    private function __construct()
    {
        $this->redis = new \Redis();
        $result = $this->redis->connect(config('redis.host'),config('redis.port'),config('redis.timeOut'));

        if ($result === false){
            throw new \Exception('redis connect error');
        }

    }

    /**
     * 存值
     * @param $key
     * @param $value
     * @param int $time
     * @return bool|string
     */
    public function set($key, $value, $time = 0)
    {
        if (!$key){
            return '';
        }
        if (is_array($value)){
            $value = json_encode($value);
        }

        if (!$time){
            return $this->redis->set($key,$value);
        }

        return $this->redis->setex($key,$time,$value);
    }

    /**
     * 获取数据
     * @param $key
     * @return bool|mixed|string
     */
    public function get($key)
    {
        if (!$key){
            return '';
        }

        return $this->redis->get($key);

    }

}












