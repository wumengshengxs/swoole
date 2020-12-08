<?php

$server = new Swoole\WebSocket\Server("0.0.0.0", 9501);

$server->set([
    'enable_static_handler' => true,
    'document_root' => "/Applications/XAMPP/xamppfiles/htdocs/swoole/html",
]);
//监听websocket链接打开事件
$server->on('open','onOpen');
function onOpen($server,$request){
    print_r($request->fd);
}

//监听websocket消息事件
$server->on('message', function (Swoole\WebSocket\Server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "this is websocket server");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();
