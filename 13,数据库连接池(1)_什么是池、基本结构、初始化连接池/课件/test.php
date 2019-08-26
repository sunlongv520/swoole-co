<?php
require __DIR__."/vendor/autoload.php";


go(function(){
   $pool=new \App\pool\PDOPool();
   $pool->initPool();


   while(true){
       \Swoole\Coroutine::sleep(1);
   }

});