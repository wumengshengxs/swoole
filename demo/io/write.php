<?php
/**
 * 异步写文件
 * FILE_APPEND 追加写文件
 */
$content = date("Y-m-d H:i:s")." 测试".PHP_EOL;
$filename = __DIR__."/1.log";
/**
 * swoole_async_writefile 的FILE_APPEND失效
 */
//swoole_async_writefile($filename,$content,function($filename){
//    //todo
//    echo "success".PHP_EOL;
//},FILE_APPEND);

go(function () use ($filename,$content)
{
    $w = Swoole\Coroutine\System::writeFile($filename, $content,FILE_APPEND);
    var_dump($w);
});


echo "start".PHP_EOL;





