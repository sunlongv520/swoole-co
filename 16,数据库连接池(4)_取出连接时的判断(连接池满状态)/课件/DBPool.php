<?php
namespace  App\pool;
use mysql_xdevapi\Exception;

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
    public function getCount(){return $this->count;}
    public function initPool(){ //根据最小连接数，初始化池
        for($i=0;$i<$this->min;$i++){
            $db=$this->newDB();
            $this->conns->push($db);
        }
        $this->count=$this->min;
    }
    public function getConnection(){//取出
        if($this->conns->isEmpty()){
            if($this->count<$this->max){//连接池没满
                $this->addDBToPool();

                return $this->conns->pop();
            }else{
                echo "没货了".PHP_EOL;
                return $this->conns->pop(5);
            }
        }
        return $this->conns->pop();
    }
    public function close($conn){//放回连接
        if($conn){
            $this->conns->push($conn);
        }
    }
    public function addDBToPool(){
        try{
            $this->count++;
            $db=$this->newDB();
            if(!$db) throw  new \Exception("db创建错误");
            $this->conns->push($db);
        }catch (\Exception $ex){
            $this->count--;
        }
    }


}