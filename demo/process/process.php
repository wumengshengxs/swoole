<?php
/**
 * 进程管理
 */
$process = new Swoole\Process(function (swoole_process $pro){
    //todo
    //类似于在终端执行脚本
    $pro->exec("/Applications/XAMPP/xamppfiles/bin/php",[__DIR__.'/../server/http_server.php']);
},false);

$pid = $process->start();

echo $pid.PHP_EOL;

swoole_process::wait();





