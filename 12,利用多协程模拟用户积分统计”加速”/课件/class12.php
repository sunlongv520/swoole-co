<?php
require_once "vendor/autoload.php";
function grantScore(int $user_id){  //统计积分
    (new \App\util\dbutil())->query("select sleep(2) ");//假设这是一个很耗时的 统计用户积分的 过程
    return rand(1,10);
}

go(function(){
   $users= (new \App\util\dbutil())->query("select user_id from users");// 取出所有用户
    $arrs=array_chunk($users,2); // [[],[],[] ,[]];
    foreach ($arrs as $users){
        go(function() use($users){
            foreach ($users as $user){
                $score=  grantScore($user["user_id"]);
                echo "userid=".$user["user_id"]."的积分是:".$score.PHP_EOL;
            }
        });
    }

});
