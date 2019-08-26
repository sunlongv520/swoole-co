<?php
namespace App\util;
use Swoole\Coroutine as co;
class dbutil{
    function query(string $sql){
        $mysql=new co\MySQL();
        $conn=$mysql->connect(['host' => '192.168.29.1', 'user' => 'shenyi', 'password' => '123123', 'database' => 'test',]);
        $statement=$mysql->prepare($sql);
        $rows=$statement->execute();
        return $rows;

    }
}