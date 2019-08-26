<?php
require __DIR__."/vendor/autoload.php";
use Swoole\Coroutine as co;

go(function(){
    $ques=[
        'PHP是不是最好的语言'=>1,
        "996恶心吗?"=>1,
        "加班是一种福气吗？"=>0
    ];
    $wg=new \App\sync\WaitGroup();
    $chan=new co\Channel();
    $result=new co\Channel(3);
    $wg->Add(2);
    go(function() use($ques,$chan,$wg){
        $ques['end']=-1;
        foreach($ques as $que=>$ans) {
            $chan->push($que);
        }
        $wg->Done();

    });
    go(function() use($ques,$chan,$result,$wg){
        while (true){
            $getQues=$chan->pop();
            if($getQues=="end")  break;
            echo $getQues.PHP_EOL;
            $getAns=fgets(STDIN);
            $result->push($getAns==$ques[$getQues]?1:0);

        }
        $wg->Done();
    });
    $wg->Wait();
    echo "开始计算结果".PHP_EOL;
    $score=0;
    for($i=0;$i<count($ques);$i++){
        $score+=$result->pop();
    }
    echo "您的得分是:$score".PHP_EOL;

});




