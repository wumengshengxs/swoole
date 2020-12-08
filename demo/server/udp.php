<?php
//创建server对象 监听127.0.0.1 9502端口 类型为SWOOLE_SOCK_UDP
$serv = new Swoole\Server("127.0.0.1",9502,SWOOLE_PROCESS,SWOOLE_SOCK_UDP);

$serv->set([
    'work_num'=>4,
    'max_request'=>10000
]);

$serv->on('Packet', function ($serv, $data, $clientInfo) {
    echo $data;
    $serv->sendto($clientInfo['address'], $clientInfo['port'], "Server ".$data);
});


$serv->start();
