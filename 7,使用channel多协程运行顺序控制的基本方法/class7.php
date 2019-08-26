<?php
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
    $chan=new co\Channel(2);

    go(function() use($chan){
        query(["select sleep(2)","select * from users where user_id=1"]);
        $chan->push(1);
    });
    go(function() use($chan){
        query(["select * from users where user_id=2"]);
        $chan->push(2);
    });

    for($i=0;$i<2;$i++){
        $chan->pop();
    }

    echo "done".PHP_EOL;
});
