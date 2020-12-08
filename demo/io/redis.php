<?php

$redisClient = new Swoole\Redis();//Swoole\redis
$redisClient->connect('127.0.0.1',6379,function (swoole_redis $redisClient, $result) {
    echo "connect".PHP_EOL;
    var_dump($result);

    //同步 redis (new Redis())->set(key,value);
    //异步
    $redisClient->set('li_111',time(),function (swoole_redis $redisClient, $result) {
        var_dump($result);
    });

    //读取
//    $redisClient->get("li_1", function (swoole_redis $redisClient, $result){
//        var_dump($result);
//        $redisClient->close();
//    });
//
//    $redisClient->keys('lih*', function (swoole_redis $redisClient, $result) {
//        var_dump($result);
//    });


});

echo "start ".PHP_EOL;












