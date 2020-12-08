<?php

/**
 *process  进程
 */
echo "process-start-time: ".date("Y-m-d H:i:s").PHP_EOL;
$urls = [
    'http://baidu.com',
    'http://sina.com',
    'http://qq.com',
    'http://souhu.com',
    'http://baidu.com?search=sinwa',
    'http://baidu.com?search=imooc',
    'http://baidu.com?search=singwa2'
];
$workers = [];
for ($i = 0; $i < 6; $i++){
    //子进程
    $process = new Swoole\Process(function (swoole_process $worker) use($i,$urls) {
        //curl
        $content = curlData($urls[$i]);
        //true 将数据存入管道中
//        echo $content.PHP_EOL;
        $worker->write($content.PHP_EOL);
    },true);
    $pid = $process->start();

    $workers[$pid] = $process;
}

foreach ($workers as $process){
    //read 从管道中读取数据
    echo $process->read().PHP_EOL;
}

function curlData($url)
{
    sleep(1);
    return $url . "  success";
}
echo "process-end-time: ".date("Y-m-d H:i:s");






