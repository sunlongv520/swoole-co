<?php
$t="Guest";
if(isset($_GET['t'])){
    sleep(3);
    $t=$_GET['t'];
}

$html=<<<data
 
   this is my server,user is :$t;
 
data;

exit($html);
