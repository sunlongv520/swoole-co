<?php
require_once "vendor/autoload.php";
use App\sync\WaitGroup;
use Swoole\Coroutine as co;
function query(array $sqls){
    $mysql=new co\MySQL();
    $conn=$mysql->connect(['host' => '192.168.29.1', 'user' => 'shenyi', 'password' => '123123', 'database' => 'test',]);
    foreach($sqls as $sql){
        $statement=$mysql->prepare($sql);
        $rows=$statement->execute();
        foreach($rows as $row){
            foreach($row as $k=>$v){
                echo $k."=>".$v.";";
            }
        }
    }
    echo PHP_EOL;
}

go(function(){
    $wg=new WaitGroup();
    $wg->Add(2);//设置协程的数量
    go(function() use($wg){
        query(["select sleep(2)","select * from users where user_id=1"]);
        $wg->Done();
    });
    go(function() use($wg){
        query(["select * from users where user_id=2"]);
        $wg->Done();
    });

   $wg->Wait();

    echo "done".PHP_EOL;
});
