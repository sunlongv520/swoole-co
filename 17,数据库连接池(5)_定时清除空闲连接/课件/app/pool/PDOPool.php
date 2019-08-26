<?php
namespace App\pool;
class PDOPool extends DBPool {

    public function __construct(int $min = 5, int $max = 10)
    {
        parent::__construct($min, $max);
        \Swoole\Runtime::enableCoroutine(true);
    }
    protected function newDB()
    {
        $dsn="mysql:host=192.168.29.1;dbname=test";
        $pdo=new \PDO($dsn,"shenyi","123123");
        return $pdo;
    }
}
