<?php

class Http
{
    CONST HOST = "0.0.0.0";
    CONST PORT = 8811;

    public $http = null;
    public function __construct()
    {
        $this->http = new Swoole\Http\Server(self::HOST, self::PORT);
        $this->http->set([
            'enable_static_handler' => true,
            'document_root' => "/Applications/XAMPP/xamppfiles/htdocs/swoole/thinkphp/public/static",
            "worker_num"=>5,
            'task_worker_num'=>4
        ]);

        $this->http->on("workerStart",[$this,'onWorkerStart']);
        $this->http->on("request",[$this,'onRequest']);
        $this->http->on("task",[$this,'onTask']);
        $this->http->on("finish",[$this,'onFinish']);
        $this->http->on("close",[$this, 'onClose']);

        $this->http->start();
    }

    /**
     * workerStart 回调
     * @param $server
     * @param $worker_id
     */
    public function onWorkerStart($server, $worker_id)
    {
        // 加载基础文件
        define('APP_PATH', __DIR__ . '/../application/');
//        require __DIR__ . '/../thinkphp/base.php';
        require __DIR__ . '/../thinkphp/start.php';
    }

    /**
     * request 回调
     * @param $request
     * @param $response
     */
    public function onRequest($request,$response)
    {
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
        $_POST['http_server'] = $this->http;
        //添加缓存区
        ob_start();
        try {
            think\Container::get('app',[APP_PATH])->run()->send();
        }catch (\Exception $e){
            //todo
        }

        $res = ob_get_contents();
        if (ob_get_contents()){
            ob_end_clean();//清除缓存区
        }
        $response->end($res);
    }


    /**
     * 异步处理机制
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     * @return string
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function onTask($serv, $taskId, $workerId,$data)
    {
        //分发task任务机制 让不同的任务走不同的逻辑
        $obj = new app\common\lib\task\Task();
        $method = $data['method'];
        $obj->$method($data['data']);

        return "on task finish"; //告诉 worker
    }

    /**
     * finish 操作是可选的，也可以不返回任何结果 返回task
     * @param $serv
     * @param $taskId
     * @param $data
     */
    public function onFinish($serv, $taskId, $data)
    {
        echo "taskId: {$taskId}\n";
        //$data是task return出来的数据
        echo "finish-data-success: {$data}\n";
    }

    /**
     * close
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd)
    {
        echo "clientid:{$fd}\n";
    }

}

new Http();

