

<div class="ink-row">
    <div class="ink-gutter">
        <div class="ink-l30">
            <nav class="ink-navigation black">
                <ul class="menu vertical tutorialMenu">
                    <li><h3 style="margin:3px; margin-left:10px;">How to play</h3></li>
                    <li><a href="#t_main">Main Goal</a></li> 
                    <li><a href="#t_basic">Basic Mechanics</a></li>
                    <li><a href="#t_roll">What is a Roll?</a></li>
                    <li><a href="#t_id">What is my ID?</a></li>
                    <li class="active"><a href="#t_rules">Full Rules</a></li>
                    
                    <li><a href="#t_classes">Classes</a>
                    <!--    <ul style="padding-left:20px;">
                            <li><a href="#c_healer"><span class="ink-label class-H">Healer</span></a></li>
                            <li><a href="#c_bard"><span class="ink-label class-B">Bard</span></a></li>
                            <li><a href="#c_warlock"><span class="ink-label class-W">Warlock</span></a></li>
                            <li><a href="#c_knigh"><span class="ink-label class-K">Knight</span></a></li>
                            <li><a href="#c_paladin"><span class="ink-label class-P">Paladin</span></a></li>
                            <li><a href="#c_deathknigh"><span class="ink-label class-DK">Death Knight</span></a></li>
                        </ul>
                    -->
                    </li>
                    <!-- <li><a>Skills</a>
                        <ul style="padding-left:20px;">
                            <li><a href="#s_taget">How to target</a></li>
                            <li><a href="#s_avenging">Avenge</a></li>
                            <li><a href="#s_heal">Heal/Revive</a></li>
                            <li><a href="#s_summon">Summons</a></li>
                            <li><a href="#s_boost">Damage Boost</a></li>
                            <li><a href="#s_critical">Critical Hits</a></li>
                            <li><a href="#s_special">Special Rolls</a></li>
                        </ul>
                    </li>
                -->
                </ul>
            </nav>
        </div>
        <div class="ink-l66" style="margin-left:20px;">
            <div class="tutorialPage" id="t_main" style="display:none;">
                <h2>Main Goal</h2>
                <p>Dragonchan is a script that converts any /b/ thread into a dragon slaying match<p>
                <p>The script parses the thread using the json API and calculates damage/classes and other skills depending on post rolls, images, replies, etc...</p>
                <p>The main goal is to kill a dragon (or any other boss) by roleplaing on /b/ posting your hits and skills and checking the script page for damage output and fight status</p>
                <p>The game focus on cooperation, as every class depends on eachother for its full benefit, this is why we implemented a diferent set of classes and skills and balanced them in a co-dependent way.</p>
                <p>Using your class specific skills you can help eachother in the quest of defeating a dragon. if cooperation is not achived the thread will simply die by itself...</p>
            </div>
            <div class="tutorialPage" id="t_roll" style="display:none;">
                <h2>What is a roll?</h2>
                <p>
                    A 'roll' consists in the last 2 digits of your post number. Ocasionaly, some skills will use the last 2 digits of the id generated for images you post.
                </p>
                <p>
                    Rolls are calculated in a way that they allways return a >0 number, this means that if your last 2 digits are "00" the script will look for your last 3 digits. if you last 3 digits are still "000", the script will look for your last 4 digits. this will go on until a >1 digit is found.
                </p>
                <p>
                    Sometimes people are going to burst >1000 damage in one hit, this is because 00 dubs are disabled on /b/ but 000 trips are allowed. the damage for this roll will be from 1000 to 9000. This is intended (same goes for quads "0000"). This is extremely rare but will make some "lucky" rolls enjoyable.
                </p>
                <p>
                    This system is only possible because /b/ has a very very very fast post per second ratio, making the last 2 digits of your post nearly random.
                </p>
            </div>
            <div class="tutorialPage" id="t_id" style="display:none;">
                <h2>What is my ID?</h2>
                <p>
                    Your ID is a randomly generated hash that 4chan gives you.
                </p>
                <p>
                    This hash is unique for every thread you enter meaning it will change from thread to thread but not from post to post.This way the script can detect exactly who you are and what have you posted in a thread, thracking the damage for each ID.
                </p>
                <p>
                    Your ID determinates your class. The script assigns you a class and because IDs are persistent only inside the same thread this class will change the next dragonraid thread you enter.
                </p>
                <p>
                    All classes are balanced, or at least we try to make them balanced, by some being common then others. This does not mean some classes suck and others don't. Its just the way the game was designed, making the classes more or less needed.
                </p>
                <hr/>
                <h3>What will my class be?</h3>
                <p>
                    The class you get depends on your ID in the current thread, you can check the Rules section to understand the class system.
                </p>
                <ul class="rules">
                    <?php include("class_rolls.tpl"); ?> 
                </ul>
            </div>
            <div class="tutorialPage" id="t_classes" style="display:none;">
                <h2>Classes</h2>
                <p>
                    There are currently 7 diferent classes, each with its own habilities
                </p>
                <h4>Support</h4>
                <ul>
                    <li><span class="ink-label class-H">Healer</span> can revive other players.</li>
                    <li><span class="ink-label class-B">Bard</span> will boost other players damage by posting images</li>
                </ul>
                <h4>Damage</h4>
                <ul>
                    <li><span class="ink-label class-W">Warlock</span> can summon diferent creatures for additional damage</li>
                    <li><span class="ink-label class-K">Knight</span> can avenge fallen soldiers for additional damage</li>
                </ul>
                <h4>Special (rare)</h4>
                 <ul>
                    <li><span class="ink-label class-P">Paladin</span> can avenge AND revive fallen soldiers</li>
                    <li><span class="ink-label class-DK">Death Knight</span> can attack after death.</li>
                     <li><span class="ink-label class-DVK">DragonBorn</span> can avenge AND revive when alive and can attack after death.</li>
                </ul>

                <hr/>
                <h3>What will my class be?</h3>
                <p>
                    The class you get depends on your ID in the current thread, you can check the Rules section to understand the class system.
                </p>

                <ul class="rules">
                    <?php include("class_rolls.tpl"); ?> 
                </ul>
            </div>
            <div class="tutorialPage" id="t_basic" style="display:none;">
                <h2>Basic Mechanics</h2>
                <p>The game is very simple. Find a dragonslayer thead and post on it.</p>
                <p>You can use this webpage to track the party damage, by placing the 4chan thread ID after the URL</p>
                <div>
                    <img class="ink-l100 ink-m90 ink-s90" src="/images/howtostart.jpg"/>
                </div>
                <h2>Starting a thead</h2>
                <p>
                    To start a new dragon slayer thread <a href="">copy/paste the thead template from the github repo</a> and start a new thead with the desired boss image.
                    <br/>
                    Its recomended that you post a link to the script in your second post, so new people can read and understad the rules and the game itself.
                    <br/>
                    <span class="note">The scrip will work with any thread ID, so fell free to highjack a dead/troll thread!</span>
                </p>
                <div>
                    <p class="ink-label warning"> You should allways check the catalog before creating a new thread.</p>
                    <p class="ink-label caution"> Please don't spam the front page with dragon raid threads!</p>
                </div>
                <h2>The Boss</h2>
                <p>
                    The boss has a radom HP depending on OP's roll. this allows for stronger or weaker dragons.
                    The minimum HP is now set to 16.000HP.
                </p>
                <h2>Damage</h2>
                <p>
                    Your damage is calculated based on your <a href="#t_roll">roll</a>.
                    The script will output everyone`s damage as well as other actions.
                    <br/>
                    Some skills (depending on your class) will add or remove damage to your roll.
                </p>
                <div>
                    <img class="ink-l100 ink-m90 ink-s90" src="/images/howtolog.jpg"/>
                </div>

                <h2>Death</h2>
                <p>
                    When you roll under 11 you will die. this means your posts will no longer do damage until you are revived. (death knights may cheat death)
                </p>
                <p>
                    Everytime someone dies, the boss will heal for a small amouth depending on the death roll. If you are a healer try reviving your falled team mates, they will thank you for that.
                </p>
                <h2>Enrage</h2>
                <p>
                    When the boss HP drops below 20% he will enrage and the minumum roll will be 22 (if you roll under 22 you die).
                    An enraged boss can not heal himself.
                </p>
                <h2>Victory</h2>
                <p>
                    The game ends when the dragon reaches 0HP.
                    By this time the script will tell you who delivered the last hit. Be noble and congratulate your new hero!
                </p>
                <h2>TOP</h2>
                <p>
                   The script keeps a sidebar with diferent TOP10 lists so you can track the raid party overall effectiveness.
                   <br/>
                   Allways keep an eye on the top damage, your ID might be there!
                </p>
            </div>
            <div class="tutorialPage" id="t_rules" style="display:none;">
                <h2>Full Rules Copypasta</h2>
                <ul class="rules">
                    <?php include("class_rolls.tpl"); ?> 
                    <li>Your last 2 digits represent the damage you do</li>
                    <li>If you roll under 11 you DIE! <i style="font-size:11px;">(your posts will no longer do damage)</i></li>
                    <li><span class="ink-label class-H">Healers</span> revive fallen soldiers by targeting them and rolling an EVEN number</li>
                    <li><span class="ink-label class-B">Bards</span> are here to motive troops! each time they post an image the next 3 posts will do bonus damage!</li>
                    <li><span class="ink-label class-K">Knights</span> can critical hit by rolling 5 or 0</li>
                    <li><span class="ink-label class-K">Knights</span> avenge fallen soldiers by targeting them and rolling an EVEN number. Avenging does more damage for the glory of the fallen mate.</li>
                    <li><span class="ink-label class-P">Paladins</span> can avenge AND revive!</li>
                    <li><span class="ink-label class-W">Warlocks</span> can summon minions by posting an image. The last 2 digits of the image filename will be added to his damage. if his roll last digit matches his minion last digit he BURSTS massive damage. If the Warlock types the words "ice", "fire", "water", "electric", or "earth" in their post, they can summon a minion of the specific element for 1.5x additional minion damage if the Beast is weak to the element. If the element is the same as the Beast, the additional minion damage will do .5x the damage instead.</li>
                    <li><span class="ink-label class-DK">Death Knights</span> can continue attacking after they die. they will do x2 damage when dead but only 2/3 when alive.</li>
                    <li><span class="ink-label class-DVK">DragonBorn</span> can avenge and revive when alive, and will transform into a Death knight after death. this is the ultimate class!</li>
                    <li>you can be avenged/revived 6 times max</li>
                    <li>The elemental grid is: Earth is weak to Ice, Water is weak to Electric, Fire is weak to Water, Electric is weak to Earth, Ice is weak to Fire.</li>
                    <li>If you roll 00 or 69 you REVIVE everyone! their damage will count again! </li>
                    <li>The boss will enrage bellow 20% HP, the minimum roll will be 22. however, he will no longer heal himself </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('.tutorialMenu a').click(function(){
            if(!this.href) return;
            
            $('.tutorialPage').hide();
            var tab = "#"+this.href.toString().split('#')[1];
            
            if(_gaq){
                _gaq.push(['_trackEvent', 'Info', tab]);
            }

            $(tab).show();
            $('.tutorialMenu a').parent().removeClass('active');
            $(this).parent().addClass('active');
        });
        
        
            $('.tutorialMenu li.active a').click();
         

    });
</script>
 