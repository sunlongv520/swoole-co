<?php
use Swoole\Coroutine\Http\Client as httpClient;
 //Swoole\Runtime::enableCoroutine(true);
function getHtml($t=false){
    $url="http://192.168.29.1/";
    if($t) $url.="?".$t;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);
    $ret = curl_exec($ch);
    curl_close($ch);
    return  $ret;
}
function getHtml2($t=false){
    $fp=stream_socket_client("tcp://192.168.29.1:80");
    $path="/";
    if($t) $path.="?".$t;
    fwrite($fp, "GET $path HTTP/1.0\r\nAccept: */*\r\n\r\n");
    $ret="";
    while (!feof($fp)) {
        $ret.=fgets($fp, 1024);
    }
    fclose($fp);
    return $ret;
}

go(function(){
   // echo getHtml("t=shenyi");
    $client=new httpClient('192.168.29.1',80);
    $client->get("/?t=shenyi");
   echo  $client->body;
    $client->close();
    });
go(function(){
  //echo getHtml();
    $client=new httpClient('192.168.29.1',80);
    $client->get("/");
    echo $client->body;
    $client->close();
});

