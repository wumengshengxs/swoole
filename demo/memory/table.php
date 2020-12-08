<?php

//创建内存表

$table = new Swoole\Table(1024);

//内存表增加一行
$table->column('id',$table::TYPE_INT,8);
$table->column('name',$table::TYPE_STRING,128);
$table->column('age',$table::TYPE_INT,8);
$table->create();

//存值
$table->set('singwa_imooc',['id'=>1,'name'=>'li','age'=>22]);

//第二种存值方案
$table['singwa_imooc_1'] = [
    'id'=>2,
    'name'=>'li123',
    'age'=>21,
];

//$table->incr('singwa_imooc_1','age',2);
$table->decr('singwa_imooc_1','age',2);

//print_r($table->get('singwa_imooc'));
print_r($table['singwa_imooc_1']);
echo 'delete'.PHP_EOL;
//删除
$table->del('singwa_imooc_1');

print_r($table['singwa_imooc_1']);








