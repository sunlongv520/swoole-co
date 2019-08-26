<?php
namespace  App\pool;
abstract class DBPool{
    private $min;
    private $max;
    private $conns;
    abstract protected function newDB();
    function __construct($min=5,$max=10)
    {
        $this->min=$min;
        $this->max=$max;
        $this->conns=new \Swoole\Coroutine\Channel($this->max);
    }
    public function initPool(){ //根据最小连接数，初始化池
        for($i=0;$i<$this->min;$i++){
            $db=$this->newDB();
            $this->conns->push($db);
        }
    }
    public function getConnection(){//取出
        return $this->conns->pop();
    }
    public function close($conn){//放回连接
        $this->conns->push($conn);
    }

}