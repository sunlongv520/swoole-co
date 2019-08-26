<?php
require __DIR__."/vendor/autoload.php";


go(function(){
   $pool=new \App\pool\PDOPool();
   $pool->initPool();

   $wg=new \App\sync\WaitGroup();
   for($i=0;$i<10;$i++){
       go(function() use($pool,$i,$wg){
           $conn=$pool->getConnection();
           $wg->Add(1);
           defer(function() use($pool,$conn,$wg){
               $pool->close($conn);//放回连接
               $wg->Done();
           });
           $state=$conn->db->query("select sleep(2)");
           $state->setFetchMode(PDO::FETCH_ASSOC);

           $rows=$state->fetchAll();
       });
   }

    for($i=0;$i<5;$i++){
        go(function() use($pool,$i,$wg){
            $conn=$pool->getConnection();
            $wg->Add(1);
            defer(function() use($pool,$conn,$wg){
                $pool->close($conn);//放回连接
                $wg->Done();
            });
            $state=$conn->db->query("select $i");
            echo $i.PHP_EOL;
        });
    }

     $wg->Wait();
    echo "目前连接池一共有:".$pool->getCount()."个DB对象".PHP_EOL;






   while(true){
       \Swoole\Coroutine::sleep(1);
   }

});