<?php
Co\run(function(){
//链接swoole tcp 服务
    $client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);

    if (!$client->connect("127.0.0.1",9501)){
            echo "链接失败";
            exit();
    }
    //php cli常亮
    fwrite(STDOUT,"请输入消息:");
    $msg = trim(fgets(STDOUT));

    //把数据发送给Tcp server服务器
    $client->send($msg);

    //接受来自server的数据
    $result = $client->recv();
    echo $result;
    $client->close();
});











