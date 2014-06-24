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
        var $_version = "1.7";

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

        //internal caches
        var $_cached_post_authors = array();
        var $_set_nicknames       = array();

        protected static $available_characters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",'0','1','2','3','4','5','6','7','8','9','+','/');



        /**
         * CONFIGS
         */
        var $min_roll = 11;
        var $min_roll_enraged = 22;
        var $max_revive_times = 6;
        var $max_avenge_times = 6;
        var $bard_buff_duration = 3;
        var $boss_hp_factor     = 300;
        var $boss_heal_factor   = 30;
        var $boss_enrage_percent = 0.2;
        var $critical_hit_ratio = 2;
        var $burst_hit_ratio    = 4;

        var $available_elements = array(
            // key, Friendly Name
            'electric',
            'fire',
            'water',
            'earth',
            'ice',
        );

        var $element_weakness = array(
            // water is weak to electric
            'electric' => 'earth',
            'fire' => 'water',
            'water' => 'electric',
            'earth' => 'ice',
            'ice' => 'fire'
        );

        var $warlock_minions = array(
            'electric' => 'Eletric Golem',
            'water' => 'Water Golem',
            'fire' => 'Fire Golem',
            'earth' => 'Earth Golem',
            'ice' => 'Frost Golem',
        );

        // Less than 22 = death while enraged
        var $_miss_hits = array('23','51','71');

        /**
         * Init functions
         * @param array $_parsed_thread Parsed thread from the json API
         */
        function __construct($_parsed_thread){


            $this->THREAD = $_parsed_thread;
            $this->OPost = $this->THREAD->posts[0];
            $this->OP = $this->OPost->id;
            $this->THREAD_ID = $this->OPost->no;


            /* Uncomment to force dev variables
            $this->OPost->com = "name@LichKing
                                difficulty@hard
                                element@ice
                                health@19900";
            */

            //boss status
            $this->BossIMG = "http://thumbs.4chan.org/b/thumb/".$this->OPost->tim."s.jpg";
            $this->setBossDifficulty('easy');
            $this->BossElement = self::getBossElement($this->OPost->no);
            $this->BossName = "RandomBeast";

            /**
             * OP COMMANDS
             */

            // OP's commands should be case sensitive, like the boss name
            $this->OPost->commands = self::parseCommandValues($this->OPost, true);

            //set OP options [difficulty@]
            if($_difficulty = self::checkForCommand('difficulty@',$this->OPost)){
                $this->setBossDifficulty($_difficulty);
            }

            //set OP options [name@]
            if($_name = self::checkForCommand('name@',$this->OPost)){
                $this->BossName = $_name;
            }

            //set OP options [element@]
            if($_element = self::checkForCommand('element@',$this->OPost)){
                if(in_array($_element,$this->available_elements)){
                    $this->BossElement = $_element;
                }
            }

            //set OP options [health@]
            if($_health = self::checkForCommand('health@',$this->OPost)){
                $this->setBossHealth((int)$_health);
            }

        }


        /**
         * main function cycle
         * Does all combat checks and assigns
         * Skips invalid posts
         * @return void
         */
        function play(){

            foreach($this->THREAD->posts as $post){
                //save the post author for later
                $this->_cached_post_authors[$post->no] = $post->id;

                //ignore OP first post
                if($post->no==$this->THREAD_ID){
                    continue;
                }

                //boss is already dead!
                if($this->BossHP<=0){
                    continue;
                }

                // Dev variables
                /*
                $post->com = "summon@fire";
                */


                //get the current player class
                $post->class = self::getPlayerClass($post->id);

                //parse post commands
                $post->commands = self::parseCommandValues($post);

                //check and set nickname from command
                if($nickname = self::checkForCommand('nickname@',$post)){
                    $this->setNickname($post->id,$nickname);
                }

                //ignore fallen players with the exeption of deadknights
                if($this->isDeadPlayer($post->id) && !in_array($post->class,array('DK','DVK'))){
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
                $post->tim      = isset($post->tim) ? $post->tim : "";

                // Default an element
                $post->chosen_element = "normal";

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

                //miss hit!
                if(in_array(self::roll($post->time),$this->_miss_hits)){
                    $action = 'miss';
                    $post->action = $action;
                    $this->log($action,$post);
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

                        //only if poster is alive (DVK)
                        if($this->isDeadPlayer($post->id)) continue;

                        //avenger!
                        if(in_array($post->class,array('K','P','DVK'))){
                            //knight, paladin and dragonborn
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
                        if(in_array($post->class,array('H','P','DVK'))){
                            //Healer, paladin and dragonborn
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
         * Set boss difficulty
         * @param  string $difficulty preg_matched difficulty
         * @return null
         */
        function setBossDifficulty($difficulty){
            switch ($difficulty) {
                case 'noob':
                    $boss_min_hp = self::roll($this->OPost->no)*$this->boss_hp_factor;
                    $this->BossHP_MAX = ($boss_min_hp < 6000 ? 6000 : $boss_min_hp);
                    $this->BossHP_MAX = ($boss_min_hp > 16000 ? 16000 : $boss_min_hp);
                    $this->BossHP = $this->BossHP_MAX;
                    $this->boss_heal_factor = 30;
                break;
                default:
                case 'easy':
                    $boss_min_hp = self::roll($this->OPost->no)*$this->boss_hp_factor;
                    $this->BossHP_MAX = ($boss_min_hp < 16000 ? 16000 : $boss_min_hp);
                    $this->BossHP = $this->BossHP_MAX;
                    $this->boss_heal_factor = 33;
                break;
                case 'medium':
                    $boss_min_hp = self::roll($this->OPost->no)*$this->boss_hp_factor*1.5;
                    $this->BossHP_MAX = ($boss_min_hp < 22000 ? 22000 : $boss_min_hp);
                    $this->BossHP = $this->BossHP_MAX;
                    $this->boss_heal_factor = 35;
                break;
                case 'hard':
                    $boss_min_hp = self::roll($this->OPost->no)*$this->boss_hp_factor*2;
                    $this->BossHP_MAX = ($boss_min_hp < 27000 ? 27000 : $boss_min_hp);
                    $this->BossHP = $this->BossHP_MAX;
                    $this->boss_heal_factor = 38;
                break;
                case 'nigger':
                    $this->BossHP_MAX = 66666;
                    $this->BossHP = $this->BossHP_MAX;
                    $this->boss_heal_factor = 20;
                break;
            }

        }

        /**
         * Overrides boss's health
         * @param  string $health preg_matched health
         */
        function setBossHealth($health){
            $this->BossHP_MAX = ($health > 27000 ? 27000 : $health);
            $this->BossHP = $this->BossHP_MAX;
        }

        function getBossElement($id) {

            $last_digit = substr($id, -1);
            $element = "normal";

            /*
            'electric' => 'Electric',
            'fire' => 'Fire',
            'water' => 'Water',
            'earth' => 'Earth',
            'ice' => 'Ice'

            */

            switch ($last_digit) {

                case 0:
                    $element = $this->available_elements[0];
                    break;
                case 1:
                    $element = $this->available_elements[0];
                    break;
                case 2:
                    $element = $this->available_elements[1];
                    break;
                case 3:
                    $element = $this->available_elements[1];
                    break;
                case 4:
                    $element = $this->available_elements[2];
                    break;
                case 5:
                    $element = $this->available_elements[2];
                    break;
                case 6:
                    $element = $this->available_elements[3];
                    break;
                case 7:
                    $element = $this->available_elements[3];
                    break;
                case 8:
                    $element = $this->available_elements[4];
                    break;
                case 9:
                    $element = $this->available_elements[4];
                    break;
            }

            return $element;
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

            $chosen_element = $post->chosen_element;

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

                    // Give W's a possible elemental damage for their pets
                    // Maybe break out into a summoner class?

                    if($_summon = self::checkForCommand('summon@',$post)){
                        $_summon_element = $_summon;
                    }

                    foreach($this->available_elements as $element) {
                        if(!empty($_summon_element) && $_summon_element == $element) {
                            $chosen_element = $element;
                            $post->chosen_element = $chosen_element;
                            break;
                        }
                    }

                    // Give the pet bonus damage if it's the boss's weakness
                    if($this->element_weakness[$this->BossElement] == $chosen_element) {
                        $_pet_damage = ceil($_pet_damage * 1.5);
                    }
                    elseif($this->BossElement == $chosen_element) {
                        // If the element is the same as the boss, make him resistant
                        $_pet_damage = ceil($_pet_damage * .5);
                    }

                    $post->_pet_damage = $_pet_damage;
                    $post->bonus+=$_pet_damage;
                }

                //death knight death bonus
                if($post->class=="DK" || $post->class=="DVK"){
                    if($this->isDeadPlayer($post->id)){
                        $post->bonus+= $post->damage;
                    }elseif($post->class=="DK"){
                        //only DK have life penalty
                        $post->bonus-= floor($post->damage/3);
                    }
                }

                if($post->class=="R"){
                    switch (self::lastDigit($post->roll)) {
                        case 0: $post->damage*=1; break;
                        case 1: $post->damage*=1; break;
                        case 2: $post->damage*=2; break;
                        case 3: $post->damage*=3; break;
                        case 4: $post->damage*=4; break;
                        case 5: $post->damage*=5; break;
                        case 6: $post->damage*=4; break;
                        case 7: $post->damage*=3; break;
                        case 8: $post->damage*=1; break;
                        case 9: $post->damage*=0; break;
                    }
                }

            }else{
                $post->bonus = 0;
            }

            //OVER NINETHOUSAND!
            if($post->damage===9000){
                $post->damage++;
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
        *  sets a nickname for a user
        * @param string $user_id  the user ID to map
        * @param string $nickname the desired nickname
        */
        function setNickname($user_id,$nickname){

            // Stop fucking making names a dickyear long
            if(strlen($nickname) > 14) {
                $nickname = substr($nickname, 0, 14);
            }

            if($nickname=="heaven"){
              return false; //fuck off
            }
            if(in_array($nickname,$this->_set_nicknames)){
                //was already used
                return false;
            }
            //set the nick
            $this->_set_nicknames[$user_id] = $nickname;
            return true;
        }


        /*
         * gets a previously set nickname
         * @param  string $user_id the user to search for
         * @return string the nickname to use
        */
        function getNickname($user_id){
            if(isset($this->_set_nicknames[$user_id])){
                return $this->_set_nicknames[$user_id]." <small>($user_id)</small>";
                //return "<b title='$user_id'>".$this->_set_nicknames[$user_id]."</b>";
            }else{
                return "<small>($user_id)</small>";
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
                    'sprite' => self::getPlayerSprite($post),
                    'weapon' => self::getPlayerWeapon($post),
                    'chosen_element' => $post->chosen_element,
                    '_pet_damage'    => isset($post->_pet_damage) ? $post->_pet_damage : false,
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
            include("template/fight.tpl");
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
            include("template/status.tpl");
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
            include("template/status_core.tpl");
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
            return (bool)(self::lastDigit($num1) == self::lastDigit($num2));
        }
        /**
         * Checks if the last digit of a numbers
         * @param  int|string $num1  Number
         * @return bool
         */
        static function lastDigit($num1){
            return (int)(substr((string)$num1,-1, 1));
        }

        /**
         * Gets the class of a player based on his ID
         * @param  string $post_id Player ID
         * @return string ['H','B','P','K']
         */
        static function getPlayerClass($post_id){

            //heaven is allways a pleb knight
            if($post_id=="Heaven"){
                return "K";
            }

            //dragonborn
            if(in_array($post_id[0],array('+','/')) && in_array($post_id[7],array('+','/'))){
                return "DVK";
            }

            //paladin
            if(in_array($post_id[0],array('+','/'))){
                return "P";
            }

            //death knight
            if(in_array($post_id[7],array('+','/'))){
                return "DK";
            }

            //healer
            if(in_array($post_id[0],array('0','1','2','3','4','5','6','7','8','9'))){
                return "H";
            }

            //bard
            if(in_array($post_id[0],array('A','E','I','O','U','a','e','i','o','u'))){
                return "B";
            }

            //warlock
            if(in_array($post_id[0],array('W','R','L','C','K','w','r','l','c','k'))){
                return "W";
            }

            //ranger
            if(in_array($post_id[0],array('X','Y','Z','x','y','z'))){
                return "R";
            }

            //knight
            return "K";
        }


        /*
         * Gets the sprite of a player based on his ID
         * @param  string $post_id Player ID
         * @return string "male_knight_1.png"
         */

        static function getPlayerSprite($post){
            // ** There's a better way to do this, but let's slap something neat together for now.

            // Let's set some variables we can expect later
            $sprite = "";
            $segment = "1";
            $class = $post->class;
            $post_id = $post->id;

            // 64 variations
            $range = self::$available_characters;


            // Knight
            if($class == "K"){
                $segment_range = array_chunk($range, 2);
            }

            // Healer
            if($class == "H"){
                $segment_range = array_chunk($range, 2);
            }

            // Warlock
            if($class == "W"){
                $segment_range = array_chunk($range, 2);
            }

            // Bard
            if($class == "B"){
                $segment_range = array_chunk($range, 3);
            }

            // Paladin
            if($class == "P"){
                $segment_range = array_chunk($range, 2);
            }

            // Death knight
            if($class == "DK"){
                $segment_range = array_chunk($range, 32);
            }

            // Dragonborn
            if($class == "DVK"){
                $segment_range = array_chunk($range, 5);
            }

            // Ranger
            if($class == "R"){
                $segment_range = array_chunk($range, 5);
            }

            $segment = array_tree_search_key($segment_range, $post_id[1]);

            $sprite .= $class . "/" . $class . "_" . $segment . ".png";

            return $sprite;
        }


        static function getPlayerWeapon($post){
            // ** There's a better way to do this, but let's slap something neat together for now.

            // Let's set some variables we can expect later
            $sprite = "";
            $segment = "1";
            $class = $post->class;
            $post_id = $post->id;

            // 64 variations
            $range = self::$available_characters;

            // Knight
            if($class == "K"){
                $segment_range = array_chunk($range, 1);
            }

            // Healer
            if($class == "H"){
                $segment_range = array_chunk($range, 2);
            }

            // Warlock
            if($class == "W"){
                $segment_range = array_chunk($range, 3);
            }

            // Bard
            if($class == "B"){
                $segment_range = array_chunk($range, 5);
            }

            // Paladin
            if($class == "P"){
                $segment_range = array_chunk($range, 3);
            }

            // Death knight
            if($class == "DK"){
                $segment_range = array_chunk($range, 3);
            }

            // Dragonborn
            if($class == "DVK"){
                $segment_range = array_chunk($range, 5);
            }

            // Ranger
            if($class == "R"){
                $segment_range = array_chunk($range, 5);
            }

            // Last character of ID, instead of the first
            $segment = array_tree_search_key($segment_range, $post_id[1]);

            $sprite .= $class . "/" . $class . "_" . $segment . ".png";

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
         * Parses a post to check for command calls
         * @param  object $post the full post object
         * @return array full command list
         */
        static function parseCommandValues($post, $case_sensitive = false){
            if(!isset($post->com)){
                return array();
            }

            if(empty($post->com)){
                return array();
            }

            $_text = $post->com;
            if($case_sensitive == false) {
                $_text = strtolower($post->com);
            }
            $_text = strip_tags($_text,"<br>");
            $_text = str_replace("<br>", " ", $_text);
            $_text = str_replace("<br/>", " ", $_text);

            $_commands = array();
            $_command_regex = '/(\w+@)([a-zA-Z0-9\S]{3,15})/i';
            if($count_commands = (int)preg_match_all($_command_regex, $_text, $match)){
                for($k=0;$k<$count_commands;$k++){
                    $_commands[$match[1][$k]] = $match[2][$k];
               }
            }

            return $_commands;

        }

        /**
         * Checks if a post is calling a set command and returns the command value
         * @param  string $command 'comand@' to check
         * @param  object $post the full post object
         * @return false|string returns the command value or false on not-found
         */
        static function checkForCommand($command,$post){

            if(isset($post->commands[$command])){
                return $post->commands[$command];
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
         * authors are var cached for speed
         * @param  int $post_number Post number to search
         * @return string post author unique ID
         */
        function getPostAuthor($post_number){
            if(isset($this->_cached_post_authors[$post_number])){
                return $this->_cached_post_authors[$post_number];
            }

            foreach($this->THREAD->posts as $post){
                if($post->no==$post_number){
                    $this->_cached_post_authors[$post_number] = $post->id;
                    return $post->id;
                }
            }

            //not found
            return false;
        }

        /**
         * Gets the full API object from replies of a certain post.
         * @param  string $post_id the post to target
         * @return array
         */
        function getPostReplies($post_id){
            $replies = array();
            foreach($this->THREAD->posts as $post){
                if(!isset($post->com)){
                  continue;
                }

                $targets = $this->getTargetPosts($post->com);
                $targets = array_keys($targets);

                $post->class  = self::getPlayerClass($post->id);
                $post->weapon = self::getPlayerWeapon($post);
                $post->sprite = self::getPlayerSprite($post);

                //clean the text, more or less
                $post->text = html_entity_decode(strip_tags($post->com));
                $post->text = preg_replace('/>>(\d+){9}/i','',$post->text);

                if(in_array($post_id,$targets)){
                    $replies[] = $post;
                }
            }
            return $replies;
        }

    }


/* Some generic helper functions */
function array_tree_search_key($a, $subkey) {
    foreach($a as $k=>$v) {
        if(in_array($subkey, $v)) {
            return $k;
        }
    }
    return 0;
}


function sprite($filename){
    $src=str_replace("//", "/", "images/sprites/rpg/".$filename);
    echo "<img src='$src' align='absmiddle'/> ";
}

?>
