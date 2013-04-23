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
     * Chan Boss Raid main class
     */
    Class DragonRaid{
        var $_version = "1.4.5";

        var $THREAD_ID;
        var $THREAD;
        var $LOG;
        var $DPS;

        var $OP;
        var $OPost;

        var $BossHP;
        var $BossHP_MAX;

        var $WINNER = array();
        var $deadPlayers = array();
        var $revivedStack = array();
        var $avengedStack = array();
        var $bardBuffs = array();
        var $bardBonusValue = 0;


        /**
         * CONFIGS
         */
        var $min_roll = 11;
        var $min_roll_enraged = 22;
        var $max_revive_times = 6;
        var $max_avenge_times = 6;
        var $bard_buff_duration = 3;
        var $boss_hp_factor     = 250;
        var $boss_heal_factor   = 30;
        var $boss_enrage_percent = 0.2;
        var $critical_hit_ratio = 2;
        var $burst_hit_ratio    = 4;


        /**
         * Init functions
         * @param array $_parsed_thread Parsed thread from the json API
         */
        function __construct($_parsed_thread){
            $this->THREAD = $_parsed_thread;
            $this->OPost = $this->THREAD->posts[0];
            $this->OP = $this->OPost->id;
            $this->THREAD_ID = $this->OPost->no;


            //boss status
            $this->BossIMG = "http://thumbs.4chan.org/b/thumb/".$this->OPost->tim."s.jpg";
            $this->BossHP_MAX = 3000+self::roll($this->OPost->no)*$this->boss_hp_factor;
            $this->BossHP = $this->BossHP_MAX;

        }


        /**
         * main function cycle
         * Does all combat checks and assigns
         * Skips invalid posts
         * @return void
         */
        function play(){

            foreach($this->THREAD->posts as $post){
                //ignore OP first post
                if($post->no==$this->THREAD_ID){
                  continue;
                }

                //boss is already dead!
                if($this->BossHP<=0){
                    continue;
                }

                //get the current player class
                $post->class = self::getPlayerClass($post->id);

                //ignore fallen players with the exeption of deadknights
                if($this->isDeadPlayer($post->id) && $post->class!=="DK"){
                    continue;
                }

                //gets the current bard buff value
                $this->bardBonusValue = $this->calculateBardBonus();

                //add link to this roll
                $post->link= "http://boards.4chan.org/b/res/".$this->THREAD_ID."#p".$post->no;

                //GET THE CURRENT ROLL
                $post->roll = self::roll($post->no,2);

                //mandatory data (that might not be on the API item)
                $post->com      = isset($post->com) ? $post->com : "";
                //$post->filename = isset($post->filename) ? $post->filename : "";
                $post->tim      = isset($post->tim) ? $post->tim : "";


                //mass resurection and damage
                if($post->roll>99){
                    $this->damage($post,false);
                    $this->massResurection($post);
                    if($this->bossIsDead()){
                        $this->WINNER = $post;
                        $action = 'winrar';
                        $post->action = $action;
                        $this->log($action,$post);
                    }
                    continue;
                }

                //mass resurection but no damage
                if($post->roll==69){
                    $this->massResurection($post);
                    continue;
                }

                //enrage the boss (only once)
                if($this->bossIsEnraged() && $this->min_roll!=$this->min_roll_enraged){
                    $this->min_roll = $this->min_roll_enraged;
                    $action = 'enrage';
                    $post->action = $action;
                    $this->log($action,$post);
                }

                //death roll!
                if($post->roll<$this->min_roll && !$this->isDeadPlayer($post->id)){
                    $action = "kill";
                    $post->action = $action;
                    $this->killPlayer($post);
                    continue;
                }

                //calculate regular hit
                $this->damage($post);

                //add bard buff!
                if($post->class=='B' && isset($post->filename)){
                   $this->addBardBuff($post);
                }

                //special hit with target
                if($post->roll%2==0){

                    //avenges and revives
                    $_targets = $this->getTargetPosts($post->com);
                    foreach($_targets as $_target_post_id => $_target_id){

                        //only dead target's post
                        if(self::roll($_target_post_id)>=$this->min_roll) continue;

                        //avenger!
                        if($post->class=='K' || $post->class=='P'){
                            //knight
                            if($this->isDeadPlayer($_target_id) && $this->canAvenge($_target_id)){
                                $this->damage($post,true,false);
                                $this->avengePlayer($_target_id);
                                $post->_target = $_target_id;
                                $action = 'avenge';
                                $post->action = $action;
                                $this->log($action,$post);
                            }
                        }

                        //Reviver!
                        if($post->class=='H' || $post->class=='P'){
                            //Healer
                            if($this->isDeadPlayer($_target_id) && $this->canRevive($_target_id)){
                                $post->_target = $_target_id;
                                $this->revivePlayer($_target_id);
                                $action = 'revive';
                                $post->action = $action;
                                $this->log($action,$post);
                            }
                        }
                    }
                }

                if($this->bossIsDead()){
                    $action = 'winrar';
                    $this->WINNER = $post;
                    $post->action = $action;
                    $this->log($action,$post);
                }


            }


        }


        /**
         * Checks if a player is dead
         * @param  string $_id Player ID
         * @return boolean
         */
        function isDeadPlayer($_id){
            return in_array($_id, $this->deadPlayers);
        }


        /**
         * Calculates and returns the current bard bonus
         * @return int Bard damage bonus
         */
        function calculateBardBonus(){
            $bonus = 0;
            foreach($this->bardBuffs as $k => $buff){
                if(0>$this->bardBuffs[$k]['duration']--){
                    $this->bardBuffs[$k]['duration']=0;
                }
                if($this->bardBuffs[$k]['duration']>0){
                    $bonus+=$this->bardBuffs[$k]['value'];
                }
            }

            return $bonus;
        }


        /**
         * Adds a bard buff to the stack
         * @param object $post the full post object
         */
        function addBardBuff($post){
            $post->bonus = ceil($post->roll/3);
            $this->bardBuffs[] = array(
                                'duration' => $this->bard_buff_duration+1,
                                'value'    => $post->bonus,
                                'buffer'   => $post,
                            );
            $action = 'buff';
            $post->action = $action;
            $this->log($action,$post);
        }


        /**
         * Applies damage to the boss
         * @param  object  $post         the full post object
         * @param  boolean $canCritical  if this attack can critical
         * @param  boolean $reportDamage if this damage should be reported
         * @return void
         */
        function damage($post,$canCritical=true,$reportDamage=true){
            //define damage
            if( ($post->class=='K') && $canCritical && self::isCriticalHit($post->roll)){
                $post->damage = $post->roll*$this->critical_hit_ratio;
            }else{
                $post->damage = $post->roll;
            }


            if($post->roll<=99){
                $post->bonus = $this->bardBonusValue;

                //warlock pet damage
                if($post->class=="W" && isset($post->filename)){

                    $_pet_damage = self::roll($post->tim);

                    //warlock burst (only if not 00)
                    if($_pet_damage<99 && self::lastDigitMatch($post->no,$post->tim)){
                        $_pet_damage = $_pet_damage*$this->burst_hit_ratio;
                    }

                    $post->bonus+=$_pet_damage;
                }

                //death knight death bonus
                if($post->class=="DK" && $this->isDeadPlayer($post->id)){
                    $post->bonus+= $post->damage;
                }

            }else{
                $post->bonus = 0;
            }


            //take the damage
            $this->BossHP-= ($post->damage+$post->bonus);

            //log the hit
            if($reportDamage){
                $action = 'damage';
                $post->action = $action;
                $this->log($action,$post);
            }
        }


        /**
         * Does a mass resurection
         * @param  object $post the full post object
         * @return void
         */
        function massResurection($post){
            //clean dead players!
            foreach($this->deadPlayers as $_target_id){
                $post->_target = $_target_id;
                $action = 'revive';
                $post->action = $action;
                $this->log($action,$post);
            }

            $this->deadPlayers = array();

            //log the hit
            $action = 'massrevive';
            $post->action = $action;
            $this->log($action,$post);
        }


        /**
         * Kills a user and heals the boss
         * @param  object $post the full post object
         * @return void
         */
        function killPlayer($post){
            //add player to the dead player poll
            $this->deadPlayers[] = $post->id;

            if(!$this->bossIsEnraged()){
                //heal the boss
                $_heal = ($post->roll*$this->boss_heal_factor);
                $this->BossHP+=$_heal;
                $post->damage=-$_heal;
                //limit the heal
                if($this->BossHP>$this->BossHP_MAX){
                    $this->BossHP = $this->BossHP_MAX;
                }
            }

            //log the death
            $action = 'death';
            $post->action = $action;
            $this->log($action,$post);
        }


        /**
         * Avenges a user
         * @param  string $avenge_target Dead user id
         * @return void
         */
        function avengePlayer($avenge_target){
            if(!isset($this->avengedStack[$avenge_target])){
                $this->avengedStack[$avenge_target] = 0;
            }
            $this->avengedStack[$avenge_target]++;
        }


        /**
         * Revives a user
         * @param  string $revive_target the dead user ID
         * @return bool
         */
        function revivePlayer($revive_target){
             foreach($this->deadPlayers as $key => $_id){
                if($_id == $revive_target){
                    if(!isset($this->revivedStack[$revive_target])){
                        $this->revivedStack[$revive_target] = 0;
                    }
                    $this->revivedStack[$revive_target]++;
                    $this->deadPlayers[$key] = null;
                    unset($this->deadPlayers[$key]);
                }
             }
        }


        /**
         * Checks if a target can be revived
         * @param  string $avenge_target the dead user ID
         * @return bool
         */
        function canRevive($revive_target){
            if(isset($this->revivedStack[$revive_target])){
                return (bool)($this->revivedStack[$revive_target]<$this->max_revive_times);
            }else{
                $this->revivedStack[$revive_target]=0;
                return true;
            }
        }


        /**
         * Checks if a target can be avenged
         * @param  string $avenge_target the dead user ID
         * @return bool
         */
        function canAvenge($avenge_target){
            if(isset($this->avengedStack[$avenge_target])){
                return (bool)($this->avengedStack[$avenge_target]<$this->max_avenge_times);
            }else{
                $this->avengedStack[$avenge_target]=0;
                return true;
            }
        }


        /**
         * Logs an action
         * @param  string $action the type of action ('damage','revive','massrevive',etc)
         * @param  object $post   the full post object
         * @return void
         */
        function log($action,$post){
            $this->LOG[] = array(
                    'link'   => $post->link,
                    'post'   => $post->no,
                    'id'     => $post->id,
                    'color'  => self::getPostColor($post->id),
                    'sprite' => self::getPlayerSprite($post),
                    'roll'   => $post->roll,
                    'class'  => $post->class,
                    'action' => $action,
                    'target' => isset($post->_target) ? $post->_target : 0,
                    'damage' => isset($post->damage) ? $post->damage : 0,
                    'bonus'  => isset($post->bonus) ? $post->bonus : 0,
                );
        }


        /**
         * Calculates and returns the top 10 damage dealers
         * @return array
         */
        function getTopDamage($max=10){
            $TOP = array();
            foreach($this->LOG as $_hit){
                if($_hit['action']=='damage' || $_hit['action']=='avenge'){
                    if(!isset($TOP[$_hit['id']])){
                        $TOP[$_hit['id']] = 0;
                    }
                    $TOP[$_hit['id']]+= (int)$_hit['damage']+$_hit['bonus'];
                }
            }

            arsort($TOP);
            $TOP = array_slice($TOP,0,$max,true);
            return $TOP;
        }


        /**
         * Calculates and returns the top revivers list
         * @return array
         */
        function getTopRevive($max=10){
            $TOP = array();
            foreach($this->LOG as $_hit){
                if($_hit['action']=='revive'){
                    if(!isset($TOP[$_hit['id']])){
                        $TOP[$_hit['id']] = 0;
                    }
                    $TOP[$_hit['id']]++;
                }
            }

            arsort($TOP);
            $TOP = array_slice($TOP,0,$max,true);
            return $TOP;
        }


        /**
         * Calculates and returs the top avengers list
         * @return array
         */
        function getTopAvenge($max=10){
            $TOP = array();
            foreach($this->LOG as $_hit){
                if($_hit['action']=='avenge'){
                    if(!isset($TOP[$_hit['id']])){
                        $TOP[$_hit['id']] = 0;
                    }
                    $TOP[$_hit['id']]++;
                }
            }

            arsort($TOP);
            $TOP = array_slice($TOP,0,$max,true);
            return $TOP;
        }

        /**
         * Calculates and returs the top avengers list
         * @return array
         */
        function getTopDeaths($max=10){
            $TOP = array();
            foreach($this->LOG as $_hit){
                if($_hit['action']=='death'){
                    if(!isset($TOP[$_hit['id']])){
                        $TOP[$_hit['id']] = 0;
                    }
                    $TOP[$_hit['id']]++;
                }
            }

            arsort($TOP);
            $TOP = array_slice($TOP,0,$max,true);
            return $TOP;
        }


        /**
         * Calculates and returs the top avengers list
         * @return array
         */
        function getTopBuffs($max=10){
            $TOP = array();
            foreach($this->LOG as $_hit){
                if($_hit['action']=='buff'){
                    if(!isset($TOP[$_hit['id']])){
                        $TOP[$_hit['id']] = 0;
                    }
                    $TOP[$_hit['id']]+=($_hit['bonus']*$this->bard_buff_duration);
                }
            }

            arsort($TOP);
            $TOP = array_slice($TOP,0,$max,true);
            return $TOP;
        }


        /**
         * Calls the main fight template
         * @return void
         */
        function display(){
            $topDamage = $this->getTopDamage();
            $topRevive = $this->getTopRevive();
            $topAvenge = $this->getTopAvenge();
            $topDeaths = $this->getTopDeaths();
            $topBuffs  = $this->getTopBuffs();

            $BATTLE = &$this->LOG;
            $BATTLE = array_reverse($BATTLE);
            //template goes here
            include("fight.tpl");
        }

        /**
         * Calls the status iframe template
         * @return void
         */
        function displayStatus(){
            $topDamage = $this->getTopDamage(3);

            $BATTLE = &$this->LOG;
            $BATTLE = array_reverse($BATTLE);
            //template goes here
            include("status.tpl");
        }
        /**
         * Calls the status iframe template
         * @return void
         */
        function displayStatusAjax(){
            $topDamage = $this->getTopDamage(3);

            $BATTLE = &$this->LOG;
            $BATTLE = array_reverse($BATTLE);

            //template goes here
            include("status_core.tpl");
        }


        /**
         * Prints a complete json string with all game informaion.
         * @return [type] [description]
         */
        function jsonAPI(){
            $this->topDamage = $this->getTopDamage();
            $this->topRevive = $this->getTopRevive();
            $this->topAvenge = $this->getTopAvenge();
            $this->topDeaths = $this->getTopDeaths();
            $this->topBuffs  = $this->getTopBuffs();

            $this->LOG = array_reverse($this->LOG);

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');

            echo json_encode($this);
        }


        /**
         * Checks if the boss is dead
         * @return bool
         */
        function bossIsDead(){
            if($this->BossHP<0){
                $this->BossHP = 0;
            }
            return (bool)($this->BossHP<=0);
        }


        /**
         * Checks if the boss is enrages depending on self::boss_enrage_percent
         * @return bool
         */
        function bossIsEnraged(){
            return (bool)($this->BossHP<=$this->BossHP_MAX*$this->boss_enrage_percent);
        }



        //**********************************************************
        // STATIC CALLS
        //**********************************************************

        /**
         * get the roll number. if posts ends in 00 it will expand 1 digit until we end up with >0 number (ex 2000)
         * @param  string  $post_number Post number
         * @param  integer $num         roll size, default: 2 (last 2 digits)
         * @return int Roll number
         */
        static function roll($post_number,$num=2){
            $r = (int)substr($post_number, strlen($post_number)-$num,strlen($post_number));
            while($r==0){
                //dubs dubs dubs
                $r = (int)substr($post_number, strlen($post_number)-$num++,strlen($post_number));
            }
            return $r;
        }

        /**
         * Checks if the last digit of 2 numbers match
         * @param  int|string $num1 First Number
         * @param  int|string $num2 Second Number
         * @return bool
         */
        static function lastDigitMatch($num1,$num2){
            return (bool)(substr((string)$num1,-1, 1) == substr((string)$num2,-1,1));
        }

        /**
         * Gets the class of a player based on his ID
         * @param  string $post_id Player ID
         * @return string ['H','B','P','K']
         */
        static function getPlayerClass($post_id){
            if(in_array($post_id[0],array('0','1','2','3','4','5','6','7','8','9'))){
                return "H";
            }
            if(in_array($post_id[0],array('A','E','I','O','U','Y','a','e','i','o','u','y'))){
                return "B";
            }
            if(in_array($post_id[0],array('+','/'))){
                return "P";
            }
            if(in_array($post_id[0],array('W','R','L','C','K'))){
                return "W";
            }
            if(strpos($post_id,'+')>0 || strpos($post_id,'/')>0){
                return "DK";
            }
            return "K";
        }

        /**
         * Gets the sprite of a player based on his ID
         * @param  string $post_id Player ID
         * @return string ['H','B','P','K']
         */
        static function getPlayerSprite($post){
            // ** There's a better way to do this, but let's slap something neat together for now.

            // Let's set some variables we can expect later
            $sprite = "";
            $segment = "1";
            $gender = "male";
            $class = $post->class;
            $post_id = $post->id;
            
            //this is a temp overwrite
            if($class=='DK') $class = 'K';
            if($class=='W')  $class = 'H';

            // 64 variations
            $range = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",'0','1','2','3','4','5','6','7','8','9','+','/');

            // Knight
            if($class == "K"){

                // Currently 9 available sprites, 6 male, 3 female
                // 64 / 9 ~= 7, so we'll chunk it into pieces of 7
                $segment_range = array_chunk($range, 7);

                // @@TODO: Can we make this simplier?
                if( in_array( $post_id[0], $segment_range[0] ) ) {
                    $gender = "male";
                    $segment = "1";
                }
                if( in_array($post_id[0], $segment_range[1] ) ) {
                    $gender = "male";
                    $segment = "2";
                }
                if( in_array($post_id[0], $segment_range[2] ) ) {
                    $gender = "male";
                    $segment = "3";
                }
                if( in_array($post_id[0], $segment_range[3] ) ) {
                    $gender = "male";
                    $segment = "4";
                }
                if( in_array($post_id[0], $segment_range[4] ) ) {
                    $gender = "male";
                    $segment = "5";
                }
                if( in_array($post_id[0], $segment_range[5] ) ) {
                    $gender = "male";
                    $segment = "6";
                }


                if( in_array( $post_id[0], $segment_range[6] ) ) {
                    $gender = "female";
                    $segment = "1";
                }
                if( in_array($post_id[0], $segment_range[7] ) ) {
                    $gender = "female";
                    $segment = "2";
                }
                if( in_array($post_id[0], $segment_range[8] ) ) {
                    $gender = "female";
                    $segment = "3";
                }

            }

            // Healer
            if($class == "H"){

                $segment_range = array_chunk($range, 7);

                // @@TODO: Can we make this simplier?
                if( in_array( $post_id[0], $segment_range[0] ) ) {
                    $gender = "female";
                    $segment = "1";
                }
                if( in_array($post_id[0], $segment_range[1] ) ) {
                    $gender = "female";
                    $segment = "2";
                }
                if( in_array($post_id[0], $segment_range[2] ) ) {
                    $gender = "female";
                    $segment = "3";
                }
                if( in_array($post_id[0], $segment_range[3] ) ) {
                    $gender = "female";
                    $segment = "4";
                }
                if( in_array($post_id[0], $segment_range[4] ) ) {
                    $gender = "female";
                    $segment = "5";
                }

                if( in_array( $post_id[0], $segment_range[6] ) ) {
                    $gender = "male";
                    $segment = "1";
                }
                if( in_array($post_id[0], $segment_range[7] ) ) {
                    $gender = "male";
                    $segment = "2";
                }
                if( in_array($post_id[0], $segment_range[8] ) ) {
                    $gender = "male";
                    $segment = "3";
                }

            }

            // Bard
            if($class == "B"){

                $segment_range = array_chunk($range, 7);

                // @@TODO: Can we make this simplier?
                if( in_array( $post_id[0], $segment_range[0] ) ) {
                    $gender = "male";
                    $segment = "1";
                }
                if( in_array($post_id[0], $segment_range[1] ) ) {
                    $gender = "male";
                    $segment = "2";
                }
                if( in_array($post_id[0], $segment_range[2] ) ) {
                    $gender = "male";
                    $segment = "3";
                }
                if( in_array($post_id[0], $segment_range[3] ) ) {
                    $gender = "male";
                    $segment = "4";
                }

                if( in_array( $post_id[0], $segment_range[4] ) ) {
                    $gender = "female";
                    $segment = "1";
                }
                if( in_array($post_id[0], $segment_range[5] ) ) {
                    $gender = "female";
                    $segment = "2";
                }
                if( in_array($post_id[0], $segment_range[6] ) ) {
                    $gender = "female";
                    $segment = "3";
                }
                if( in_array($post_id[0], $segment_range[7] ) ) {
                    $gender = "female";
                    $segment = "4";
                }
                if( in_array($post_id[0], $segment_range[8] ) ) {
                    $gender = "female";
                    $segment = "5";
                }


            }

            // Bard
            if($class == "P"){

                $segment_range = array_chunk($range, 21);

                // @@TODO: Can we make this simplier?
                if( in_array( $post_id[0], $segment_range[0] ) ) {
                    $gender = "male";
                    $segment = "1";
                }
                if( in_array($post_id[0], $segment_range[1] ) ) {
                    $gender = "male";
                    $segment = "2";
                }
                if( in_array($post_id[0], $segment_range[2] ) ) {
                    $gender = "female";
                    $segment = "1";
                }


            }

            /*
            @@ TODO: Better revive sequence
            if(isset($post->action) && $post->action == "revive") {
                $gender = "female";
                $class = "reviver";
                $segment = "1";
            }
            */

            $sprite .= $gender . "_" . $class . "_" . $segment . ".png";

            return $sprite;
        }

        /**
         * Gets the roll critical status.
         * will return true for numbers ending in 5 or 0 (defined by $this->critical_hit_mod)
         * @param  int $num Roll digits from self::roll()
         * @return bool
         */
        static function isCriticalHit($num){
            if($num%5== 0){
                return true;
            }else{
                return false;
            }
        }

        /**
         * Gets the targeted posts any text
         * @param  string $text post text
         * @return array post numbers
         */
        function getTargetPosts($text){
            $text = html_entity_decode($text);
            $preg = preg_match_all('/>>(\d+){9}/i', $text,$raw);
            $match = array();
            if(isset($raw[0])){
                foreach ($raw[0] as $key => $value) {
                    $match[$key] = str_replace(">", '', $value);
                }
            }

            $match = array_unique($match);
            $players = array();
            foreach($match as $_post_id){
                $players[$_post_id]= $this->getPostAuthor($_post_id);
            }

            $players = array_unique($players);
            return $players;
        }

        /**
         * returns the author of a post
         * @param  int $post_number Post number to search
         * @return string post author unique ID
         */
        function getPostAuthor($post_number){
            foreach($this->THREAD->posts as $post){
                if($post->no==$post_number){
                    return $post->id;
                }
            }

            //not found
            return false;
        }

        static function getPostColor($id){
            $md5 = md5($id);
            $r = substr($md5, 0,2);
            $g = substr($md5, 5,2);
            $b = substr($md5, 10,2);

            return "#".$r.$g.$b;
        }


    }




?>
