<?php

/**
 * 协程
 */

$http = new Swoole\Http\Server('0.0.0.0', 8001);

$http->on('request', function($request, $response) {
    //获取redis 里面的key的内容 然后输出到浏览器

    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    $value = $redis->get($request->get['key']);
    $response->header("Content-Type", "text/plain");
    $response->end($value);
});

$http->start();








