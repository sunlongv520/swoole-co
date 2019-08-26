<?php
namespace App\pool;
class CoMySqlPool extends DBPool {

    public function __construct(int $min = 5, int $max = 10)
    {
        parent::__construct($min, $max);
    }
    protected function newDB()
    {
        $mysql=new \Swoole\Coroutine\MySQL();
        $mysql->connect([
            'host' => '192.168.29.1',
            'user' => 'shenyi',
            'password' => '123123',
            'database' => 'test',
        ]);
        return $mysql;

    }
}
