<?php
namespace  App\pool;
abstract class DBPool{
    private $min;
    private $max;
    private $conns;
    private $count;//当前所有连接数
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
        $this->count=$this->min;
    }
    public function getConnection(){//取出
        if($this->conns->isEmpty()){
            if($this->count<$this->max){
                $db=$this->newDB();
                $this->conns->push($db);
                $this->count++;
            }

        }
        return $this->conns->pop();
    }
    public function close($conn){//放回连接
        if($conn){
            $this->conns->push($conn);
        }

    }

}