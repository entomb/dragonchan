<?php
//chan Boss Raid v1.3.1
error_reporting(0);


/**
 * @route /info
 * Load the "more info" page template
 */
if($_GET['id']==="info"){
    include 'info.php';
    exit();
}

/**
 * The thread ID
 * @var int
 */
$thread_id = (int)$_GET['id'];

/**
 * the API url for the thread FEED
 * IDEA: extend this to other boards
 * @var string
 */
$api_url   = "http://api.4chan.org/b/res/$thread_id.json";


/**
 * @try
 * decode the 4chan-api response.
 */
try{
    $JSON = file_get_contents($api_url);
    $THREAD = json_decode($JSON);
}catch(Exeption $e){
    /**
     * An error parsing the thread (possibly HTTP/404)
     */
    exit("that is not a valid 4chan thead id...");
}

/**
 * Thread has no posts
 */
if(!isset($THREAD->posts) || count($THREAD->posts)<1){
    exit("that is not a valid 4chan thead id...");
}


//require the main class
include("dragonraid.php");


/**
 * This is the main instance
 * @var Raid
 */
$Raid = new DragonRaid($THREAD);

//process the game rules
$Raid->play();

if(isset($_GET['id']) && strpos($_GET['id'],'/json')>0){
    /**
     * loads the fight HTML template
     */
    $Raid->jsonAPI();
}else{
    /**
     * loads the fight json feed
     */
    $Raid->display();
}


//EOF
?>
