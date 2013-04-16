<?php

    /**
     * Chan Boss Raid main class
     */
    Class DragonRaid{

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


        /**
         * CONFIGS
         */
        var $min_roll = 11;
        var $min_roll_enraged = 22;
        var $max_revive_times = 4;
        var $max_avenge_times = 4;
        var $boss_hp_factor     = 200;
        var $boss_heal_factor   = 30;
        var $boss_enrage_percent = 0.2;
        var $critical_hit_ratio = 2;


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
            $this->BossIMG = "http://0.thumbs.4chan.org/b/thumb/".$this->OPost->tim."s".$this->OPost->ext;
            $this->BossHP_MAX = self::roll($this->OPost->no)*$this->boss_hp_factor;
            $this->BossHP = $this->BossHP_MAX;

        }


        /**
         * main function cycle
         */
        function play(){

            foreach($this->THREAD->posts as $post){
                //ignore OP posts
                if($post->id==$this->OP) continue;

                //ignore dead knights
                if($this->isDeadPlayer($post->id)) continue;

                //boss is dead!
                if($this->BossHP<=0) continue;


                //add link to this roll
                $post->link= "http://boards.4chan.org/b/res/".$this->THREAD_ID."#p".$post->no;
                $post->class = self::getPlayerClass($post->id);

                //GET THE CURRENT ROLL
                $post->roll = self::roll($post->no,2);
                $post->com = isset($post->com) ? $post->com : "";

                //mass resurection and damage
                if($post->roll>99){
                    $this->damage($post,false);
                    $this->massResurection($post); 
                    if($this->bossIsDead()){
                        $this->WINNER = $post;
                        $this->log('winrar',$post);
                    }
                    continue;
                }

                //mass resurection but no damage
                if($post->roll==69){
                    $this->massResurection($post); 
                    continue; 
                }

                if($this->bossIsEnraged() &&  $this->min_roll!=$this->min_roll_enraged){
                    $this->min_roll = $this->min_roll_enraged;
                    $this->log('enrage',$post);
                }

                //death roll!
                if($post->roll<$this->min_roll){
                    $this->killPlayer($post);
                    continue;
                }

                //special hit with target
                if(self::isCriticalHit($post->roll)){
                    $_targets = $this->getTargetPosts($post->com);
                    foreach($_targets as $_target_post_id => $_target_id){

                        if(self::roll($_target_post_id)>=$this->min_roll) continue;

                        if($post->class=='K'){
                            //knight
                            if($this->isDeadPlayer($_target_id) && $this->canAvenge($_target_id)){
                                $this->damage($post,true,false);
                                $this->avengePlayer($_target_id);
                                $post->_target = $_target_id; 
                                $this->log('avenge',$post);
                            }
                        }
                        if($post->class=='H'){
                            //Healer
                            if($this->isDeadPlayer($_target_id) && $this->canRevive($_target_id)){
                                $post->_target = $_target_id;
                                $this->revivePlayer($_target_id);
                                $this->log('revive',$post);
                            }
                        }
                    }
                }

                //regular hit
                $this->damage($post);

                if($this->bossIsDead()){
                    $this->WINNER = $post;
                    $this->log('winrar',$post);
                }

                

            }

        }

        function isDeadPlayer($_id){
            return in_array($_id, $this->deadPlayers);
        }


        static function getPlayerClass($post_id){
            if(in_array($post_id[0],array('0','1','2','3','4','5','6','7','8','9'))){
                return "H";
            }
            return "K";
        }

        function damage($post,$canCritical=true,$reportDamage=true){
            //define damage
            if($post->class=='K' && $canCritical && self::isCriticalHit($post->roll)){
                $post->damage = $post->roll*$this->critical_hit_ratio;
            }else{
                $post->damage = $post->roll;
            }

            //take the damage
            $this->BossHP-=$post->damage;

            //log the hit
            if($reportDamage){
                $this->log('damage',$post);
            }
        }

        function massResurection($post){
           //clean dead players!
           $this->deadPlayers = array();

           //log the hit
           $this->log('massrevive',$post);
        }

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
            $this->log('death',$post);
        }

        function avengePlayer($avenge_target){
            if(!isset($this->avengedStack[$avenge_target])){
                $this->avengedStack[$avenge_target] = 0;
            }
            $this->avengedStack[$avenge_target]++;
        }


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


        function canRevive($revive_target){
            if(isset($this->revivedStack[$revive_target])){
                return (bool)($this->revivedStack[$revive_target]<$this->max_revive_times);
            }else{
                $this->revivedStack[$revive_target]=0;
                return true;
            }
        }

        function canAvenge($avenge_target){
            if(isset($this->avengedStack[$avenge_target])){
                return (bool)($this->avengedStack[$avenge_target]<$this->max_avenge_times);
            }else{
                $this->avengedStack[$avenge_target]=0;
                return true;
            }
        }


        function log($action,$post){
            $this->LOG[] = array(
                    'link'   => $post->link,
                    'post'   => $post->no,
                    'id'     => $post->id,
                    'roll'   => $post->roll,
                    'class'  => $post->class,
                    'action' => $action,
                    'target' => isset($post->_target) ? $post->_target : 0,
                    'damage' => isset($post->damage) ? $post->damage : 0,
                );
        }


        function getTopDPS(){
            $DPS = array();
            foreach($this->LOG as $_hit){
                if($_hit['action']=='damage' || $_hit['action']=='avenge'){
                    if(!isset($DPS[$_hit['id']])){
                        $DPS[$_hit['id']] = 0;
                    }
                    $DPS[$_hit['id']]+= (int)$_hit['damage'];
                } 
            }

            arsort($DPS);
            $DPS = array_slice($DPS,0,10,true);
            return $DPS;
        }


        function display(){
            $DPS = $this->getTopDPS();
            $BATTLE = &$this->LOG;
            $BATTLE = array_reverse($BATTLE);
            //template goes here
            include("fight.tpl");
        }

        function bossIsDead(){
            if($this->BossHP<0){
                $this->BossHP = 0;
            }
            return (bool)($this->BossHP<=0);
        }

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


    }




?>