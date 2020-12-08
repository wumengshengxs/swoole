<?php

/**
 * ws 优化 基础类库
 */


class Ws
{
    CONST HOST = "0.0.0.0";
    CONST PORT = 8812;

    public $ws = null;
    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server(self::HOST, self::PORT);
        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2,
        ]);

        $this->ws->on("open",[$this, 'onOpen']);
        $this->ws->on("message",[$this, 'onMessage']);
        $this->ws->on("task",[$this,'onTask']);
        $this->ws->on("finish",[$this,'onFinish']);
        $this->ws->on("close",[$this, 'onClose']);

        $this->ws->start();
    }
    /**
     *  监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request)
    {
        var_dump($request->fd);
        //每两秒钟执行
        if ($request->fd == 1){
            Swoole\Timer::tick(2000,function($timer_id){
                echo "2s: timerId:{$timer_id}\n";
            });
        }
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo "ser-push-message: {$frame->data}\n";

        //todo 10s
        $data = [
            'task' => 1,
            'fd' => $frame->fd,
        ];
//        $ws->task($data);
        Swoole\Timer::after(5000,function () use ($ws, $frame) {
            echo " 5s-after\n";
            $ws->push($frame->fd, "server-time-after\n");
        });
        $ws->push($frame->fd, "server-push: ".date("Y-m-d H:i:s"));
    }

    /**
     * task 异步处理机制
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     * @return string
     */
    public function onTask($serv, $taskId, $workerId,$data)
    {
        print_r($data);

        //耗时场景 10s
        sleep(10);
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

$obj = new Ws();

