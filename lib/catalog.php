<?php
/**
 * DragonRaid - A prototype script to transform any /b/ thread into a dragon slaying match.
 *
 * @author Jonathan Tavares <the.entomb@gmail.com>
 * @license GNU General Public License, version 3
 * @link https://github.com/entomb/dragonchan GitHub Source
 * @filesource
 *
 *
*/


    /**
     * 4chan catalog parser
     */


Class chanCatalog{

    var $api_url = "http://api.4chan.org/b/catalog.json";
    var $_is_cached_request = false;
    var $CATALOG;

    function __construct(){
         /**
         * MEMCACHE implementation
         */
        if(getenv("MEMCACHIER_SERVERS")){
            include('lib/MemcacheSASL.php');
            $server_pieces = explode(':', getenv("MEMCACHIER_SERVERS"));
            $m = new MemcacheSASL;
            $m->addServer($server_pieces[0], $server_pieces[1]);
            $m->setSaslAuthData(getenv("MEMCACHIER_USERNAME"), getenv("MEMCACHIER_PASSWORD"));

            $_cache_key = "4chan_catalog_b";

            if(!($CATALOG = $m->get($_cache_key))){
                $this->_is_cached_request = false;
                //no cache is set
                $JSON = file_get_contents($this->api_url);
                $CATALOG = json_decode($JSON);
                $m->add($_cache_key,$CATALOG,getenv("MEMCACHIER_EXPIRE"));
            }else{
                $this->_is_cached_request = true;
            }
        }else{
            $this->_is_cached_request = false;
            //no cache servers are set (localhost?)
            $JSON = file_get_contents($this->api_url);
            $CATALOG = json_decode($JSON);
        }


        $this->CATALOG = $CATALOG;

    }


}