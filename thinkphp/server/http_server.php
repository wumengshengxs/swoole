<?php



$http = new Swoole\Http\Server("0.0.0.0",8811);

$http->set([
    'enable_static_handler' => true,
    'document_root' => "/Applications/XAMPP/xamppfiles/htdocs/swoole/thinkphp/public/static",
    "worker_num"=>5,
]);

$http->on('WorkerStart',function (swoole_server $server, $worker_id) {
    // 加载基础文件
    define('APP_PATH', __DIR__ . '/../application/');
    require __DIR__ . '/../thinkphp/base.php';
});


$http->on("request", function($request,$response) use($http){
//    require_once __DIR__ . '/../thinkphp/base.php';
    $_SERVER = [];
    if (isset($request->server)) {
        foreach ($request->server as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }

    if (isset($request->header)) {
        foreach ($request->header as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;

        }
    }

    if (isset($request->get)) {
        foreach ($request->get as $k => $v) {
            $_GET[$k] = $v;

        }
    }
    if (isset($request->post)) {
        foreach ($request->post as $k => $v) {
            $_POST[$k] = $v;

        }
    }
    //添加缓存区
    ob_start();
    try {
        think\Container::get('app',[APP_PATH])->run()->send();
    }catch (\Exception $e){
        //todo
    }
    //获取缓存区
//    echo "-action-".request()->action().PHP_EOL;

    $res = ob_get_contents();
if (ob_get_contents()){
    ob_end_clean();//清除缓存区
}
    $response->end($res);
});



$http->start();

