<?php
/**
 * DragonRaid - A prototype script to transform any /b/ thread into a dragon slaying match.
 *
 * @version  1.3.1
 * @author Jonathan Tavares <the.entomb@gmail.com>
 * @license GNU General Public License, version 3
 * @link https://github.com/entomb/dragonchan GitHub Source
 * @filesource
 *
 *
*/

//no errors on production please
error_reporting(0);


/**
 * @route /info
 * Load the "more info" page template
 */
if(isset($_GET['id']) && $_GET['id'] === "info" || !isset($_GET['id'])){
    include 'template/info.tpl';
    exit();
}

/**
 * The thread ID
 * @var int
 */
$thread_id = (isset($_GET['id']) ? (int)$_GET['id'] : 0);

/**
 * the API url for the thread FEED
 * IDEA: extend this to other boards
 * @var string
 */
$api_url = "http://api.4chan.org/b/res/$thread_id.json";


/**
 * @try
 * decode the 4chan-api response.
 */
if($thread_id > 0) {
    try
    {
        /**
         * MEMCACHE implementation
         */
        if(getenv("MEMCACHIER_SERVERS")){
            include('lib/MemcacheSASL.php');
            $server_pieces = explode(':', getenv("MEMCACHIER_SERVERS"));
            $m = new MemcacheSASL;
            $m->addServer($server_pieces[0], $server_pieces[1]);
            $m->setSaslAuthData(getenv("MEMCACHIER_USERNAME"), getenv("MEMCACHIER_PASSWORD"));

            $thread_cache_key = "4chan_thread_$thread_id";

            if(!($THREAD = $m->get($thread_cache_key))){
                $_is_cached_request = false;
                //no cache is set
                $JSON = file_get_contents($api_url);
                $THREAD = json_decode($JSON);
                $m->add($thread_cache_key,$THREAD,getenv("MEMCACHIER_EXPIRE"));
            }else{
                $_is_cached_request = true;
            }
        }else{
            $_is_cached_request = false;
            //no cache servers are set (localhost?)
            $JSON = file_get_contents($api_url);
            $THREAD = json_decode($JSON);
        }


    }
    catch(Exeption $e){
        /**
         * An error parsing the thread (possibly HTTP/404)
         */
        include("template/invalid_thread.tpl");
        exit();
    }
}

/**
 * Thread has no posts
 */
if(!isset($THREAD->posts) || count($THREAD->posts)<1){
    include("template/invalid_thread.tpl");
    exit();
}


//require the main class
include("lib/dragonraid.php");


/**
 * This is the main instance
 * @var Raid
 */
$Raid = new DragonRaid($THREAD);
$Raid->cache_status = isset($_is_cached_request) ? $_is_cached_request : false;

//process the game rules
$Raid->play();

if(isset($_GET['id']) && strpos($_GET['id'],'/json')>0){
    /**
     * loads the fight HTML template
     */
    $Raid->jsonAPI();

}elseif(isset($_GET['id']) && strpos($_GET['id'],'/status')>0){
    /**
     * loads the status iframe
     */
    $Raid->displayStatus();

}elseif(isset($_GET['id']) && strpos($_GET['id'],'/ajax')>0){
    /**
     * loads the status iframe
     */
    $Raid->displayStatusAjax();

}else{
    /**
     * loads the fight json feed
     */
    $Raid->display();
}


//EOF
?>
