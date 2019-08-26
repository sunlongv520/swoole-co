 <?php
 use Swoole\Coroutine as co;
$chan=new co\Channel(1);
 go(function() use($chan){ //只负责 计算  cpu
     $count=0;
     for($i=1;$i<=3;$i++){
         $count=$count+$i;
         co::sleep(1);
     }
     $chan->push($count);

 });

 go(function() use($chan){  //只负责输出  IO
     echo $chan->pop().PHP_EOL;
 });



