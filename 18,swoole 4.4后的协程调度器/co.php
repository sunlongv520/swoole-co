<?php
$scheduler = new \Swoole\Coroutine\Scheduler;
$scheduler->add(function(){

    echo "aaaa".PHP_EOL;
});

echo "bbb".PHP_EOL;
$scheduler->start();