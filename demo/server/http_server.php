<?php

$http = new Swoole\Http\Server("0.0.0.0",8811);

$http->set([
    'enable_static_handler' => true,
    'document_root' => "/Applications/XAMPP/xamppfiles/htdocs/swoole/html",
]);
$http->on("request", function($request,$response){
    $content = [
        'date'=>date("Y-m-d H:i:s"),
        'get'=>$request->get,
        'post'=>$request->post,
        'header'=>$request->header
    ];

    Swoole\Async::writeFile(__DIR__."/success.log",json_encode($content) ,function($filename){
        //todo
        echo "success".PHP_EOL;
    },FILE_APPEND);

    $response->end("sss".json_encode($request->get));
});
$http->start();

