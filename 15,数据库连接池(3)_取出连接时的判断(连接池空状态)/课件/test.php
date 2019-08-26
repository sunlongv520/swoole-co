<?php
require __DIR__."/vendor/autoload.php";


go(function(){
   $pool=new \App\pool\PDOPool();
   $pool->initPool();

   for($i=0;$i<5;$i++){
       go(function() use($pool,$i){
           $conn=$pool->getConnection();
           defer(function() use($pool,$conn){
               $pool->close($conn);//放回连接
           });
           $state=$conn->query("select sleep(10)");
           $state->setFetchMode(PDO::FETCH_ASSOC);
           $rows=$state->fetchAll();
       });
   }

    for($i=0;$i<3;$i++){
        go(function() use($pool,$i){
            $conn=$pool->getConnection();
            defer(function() use($pool,$conn){
                $pool->close($conn);//放回连接
            });
            $state=$conn->query("select $i");
            $state->setFetchMode(PDO::FETCH_ASSOC);
            $rows=$state->fetchAll();
            var_dump($rows);
        });
    }







   while(true){
       \Swoole\Coroutine::sleep(1);
   }

});