<?php
namespace app\index\controller;

use app\common\lib\ali\Sms;
use think\Exception;

class Index
{
    public function index()
    {
       return '';
    }

    public function li()
    {
        $date = date('Y-m-d H:i:s');
        return $date;
    }


    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
