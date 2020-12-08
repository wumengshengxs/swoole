<?php

/**
 * 异步mysql
 */

Class AysMysql
{
    public $db = "";
    public $dbConfig =  [];

    /**
     * mysql 配置
     * AysMysql constructor.
     */
    public function __construct()
    {
        //new swoole_mysql;
        $this->db = new Swoole\MySQL();
        $this->dbConfig = [
            'host' => "127.0.0.1",
            "port" => "3306",
            "user" => "root",
            "password" => "",
            "database" => "swoole",
            "charset" => "utf8"
        ];
    }

    public function update()
    {

    }

    public function add()
    {

    }

    /**
     * mysql 执行逻辑
     * @param $id
     * @param $username
     * @return bool
     * @throws \Swoole\Mysql\Exception
     */
    public function execute($id, $username)
    {
        // connect
        $this->db->connect($this->dbConfig,function($mysql,$result){
            echo "mysql-connect".PHP_EOL;
            if ($result === false){
                var_dump($this->db->connect_error);
            }

            $sql = "select * from test where id = 1";
            //query
            $mysql->query($sql,function ($mysql,$result){
                //select result 返回查询的结果内容
                //add update delete result 返回的是布尔类型
                if ($result === false){
                    //todo
                    var_dump($mysql->connect_error);
                }elseif($result === true){//add update delete
                    //todo
//                    var_dump($result);
                }else{
//                    print_r($result);
                }
                $mysql->close();
                $this->db->close();
                echo "FALSE".PHP_EOL;
            });
        });
        echo "TRUE".PHP_EOL;
        return true;
    }


}

$obj = new AysMysql();
$obj->execute(1,'123123');
echo "123123".PHP_EOL;



