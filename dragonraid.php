<?php


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

        var $min_roll = 11;
        var $min_roll_enraged = 22;

        /*
        TODO: config vars

        var $config = array(
                'boss_hp_factor'   => 200,
                'boss_heal_factor' => 100,
                'critical_hit_ratio' => 2,
                'critical_hit_mod'   => 5,
            );
        */

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
            $this->BossHP_MAX = self::roll($this->OPost->no)*200;
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
                if(in_array($post->id, $this->deadPlayers)) continue;

                //boss is dead!
                if($this->BossHP<=0) continue;


                //add link to this roll
                $post->link= "http://boards.4chan.org/b/res/".$this->THREAD_ID."#p".$post->no;
                $post->class = self::getPlayerClass($post->id);

                //GET THE CURRENT ROLL
                $post->roll = self::roll($post->no,2);

                //mass resurection and damage
                if($post->roll>99){
                    $this->damage($post,false);
                    $this->massResurection($post);
                    continue;
                }

                //mass resurection but no damage
                if($post->roll==69){
                    $this->massResurection($post);
                    continue;
                }

                if($this->bossIsEnraged()){
                    $this->min_roll = $this->min_roll_enraged;
                    $this->log('enrage',$post);
                }

                //death roll!
                if($post->roll<$this->min_roll){
                    $this->killPlayer($post);
                    continue;
                }

                //regular hit
                $this->damage($post);

                if($this->bossIsDead()){
                    $this->WINNER = $post;
                    $this->log('winrar',$post);
                }

                //special hit with target
                if(self::isCriticalHit($post->roll)){
                    $_targets = self::getTargetPosts($post->com);
                    foreach($_targets as $_id){
                        if($post->class=='K'){
                            //knight
                            if(in_array($_id, $this->deadPlayers)){
                                $this->damage($post);
                                $this->log('avenge',$post);
                            }
                        }
                        if($post->class=='H'){
                            //Healer
                            if(in_array($_id, $this->deadPlayers)){
                               //Revive target
                               //TODO:
                            }
                        }
                    }
                }

            }

        }


        static function getPlayerClass($post_id){
            //return "H";
            return "K";
        }

        function damage($post,$canCritical=true){
            //define damage
            if($post->class=='K' && $canCritical && self::isCriticalHit($post->roll)){
                $post->damage = $post->roll*2;
            }else{
                $post->damage = $post->roll;
            }

            //take the damage
            $this->BossHP-=$post->damage;

            //log the hit
            $this->log('damage',$post);
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
                $this->BossHP+=($post->roll*100);
                $this->log('bossheal',$post);
                //limit the heal
                if($this->BossHP>$this->BossHP_MAX){
                    $this->BossHP = $this->BossHP_MAX;
                }
            }

            //log the death
            $this->log('death',$post);
        }


        function log($action,$post){
            $this->LOG[] = array(
                    'link'   => $post->link,
                    'post'   => $post->no,
                    'id'     => $post->id,
                    'roll'   => $post->roll,
                    'class'  => $post->class,
                    'action' => $action,
                    'damage' => isset($post->damage) ? $post->damage : 0,
                );
        }


        function getTopDPS(){
            $DPS = array();
            foreach($this->LOG as $_hit){
                if($_hit['action']!='damage') continue;

                if(!isset($DPS[$_hit['id']])){
                    $DPS[$_hit['id']] = 0;
                }
                $DPS[$_hit['id']]+= (int)$_hit['damage'];
            }

            arsort($DPS);
            $DPS = array_slice($DPS,0,10,true);
            return $DPS;
        }


        function display(){
            $DPS = $this->getTopDPS();
            $BATTLE = &$this->LOG;
            print_r($BATTLE);
            //template goes here
            //include();
        }

        function bossIsDead(){
            return (bool)($this->BossHP<=0);
        }

        function bossIsEnraged(){
            return (bool)($this->BossHP<=$this->BossHP_MAX*0.2);
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
         * will return true for numbers ending in 5 or 0
         * @param  int $num Roll digits from self::roll()
         * @return bool
         */
        static function isCriticalHit($num){
            if($num%5 == 0){
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
        static function getTargetPosts($text){
            $preg = preg_match_all('/>>(\d+){9}/i', $text,$raw);
            $match = array();
            if(isset($raw[0])){
                foreach ($raw[0] as $key => $value) {
                    $match[$key] = str_replace(">", '', $value);
                }
            }

            $match = array_unique($match);
            return $match;
        }

        /**
         * returns the author of a post
         * @param  int $post_number Post number to search
         * @return string post author unique ID
         */
        static function getPostAuthor($post_number){
            foreach($THREAD->posts as $post){
                if($post->num==$post_number){
                    return $post->id;
                }
            }

            //not found
            return false;
        }


    }




?>