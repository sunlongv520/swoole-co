<?php
use Swoole\Coroutine as co;
$ques=[
    'PHP是不是最好的语言'=>1,
    "996恶心吗?"=>1,
    "加班是一种福气吗？"=>0
];

$chan=new co\Channel();

go(function() use($ques,$chan){
    $ques['end']=-1;
    foreach($ques as $que=>$ans) {
        $chan->push($que);
    }
});
go(function() use($ques,$chan){
    while (true){
        $getQues=$chan->pop();
        if($getQues=="end")  break;
        echo $getQues.PHP_EOL;
        $getAns=fgets(STDIN);
        if($getAns==$ques[$getQues]){
            echo "正确".PHP_EOL;
        }
        else
            echo "错误".PHP_EOL;
    }
});




