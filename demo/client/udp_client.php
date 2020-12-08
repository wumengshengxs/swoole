<?php
Co\run(function(){
    $client = new Swoole\Coroutine\Client(SWOOLE_SOCK_UDP);
    if (!$client->connect('127.0.0.1', 9501, 0.5))
    {
        echo "链接失败\n";exit();
    }

    //php cli常亮
    fwrite(STDOUT,"请输入消息:");
    $msg = trim(fgets(STDOUT));

    //把数据发送给Tcp server服务器
    $client->send($msg);
    echo $client->recv();
    $client->close();
});