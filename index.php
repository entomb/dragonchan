<?php
//chan Boss Raid v1.3
error_reporting(0);
if($_GET['id']==="info"){
    include 'info.php';
    exit();
}
$thread_id = (int)$_GET['id'];
$api_url   = "http://api.4chan.org/b/res/$thread_id.json";

try{
    $JSON = file_get_contents($api_url);
    $THREAD = json_decode($JSON);
}catch(Exeption $e){
    exit("that is not a valid 4chan thead id...");
}

if(!isset($THREAD->posts) || count($THREAD->posts)<1){
    exit("that is not a valid 4chan thead id...");
}


include("dragonraid.php");

$Raid = new DragonRaid($THREAD);
$Raid->play();
$Raid->display();



?>