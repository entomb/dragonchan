

<div class="ink-row">
    <div class="ink-gutter">
        <div class="ink-l30">
            <nav class="ink-navigation black">
                <ul class="menu vertical tutorialMenu">
                    <li><h3>How to play</h3></li>
                    <li><a href="#t_main">Main Goal</a></li>
                    <li><a href="#t_basic">Basic Mechanics</a></li>
                    <li><a href="#t_roll">What is a Roll?</a></li>
                    <li><a href="#t_id">What is my ID?</a></li>
                    <!--
                    <li><a href="#t_classes">Classes</a>
                        <ul style="padding-left:20px;">
                            <li><a href="#c_healer"><span class="ink-label class-H">Healer</span></a></li>
                            <li><a href="#c_bard"><span class="ink-label class-B">Bard</span></a></li>
                            <li><a href="#c_warlock"><span class="ink-label class-W">Warlock</span></a></li>
                            <li><a href="#c_knigh"><span class="ink-label class-K">Knight</span></a></li>
                            <li><a href="#c_paladin"><span class="ink-label class-P">Paladin</span></a></li>
                            <li><a href="#c_deathknigh"><span class="ink-label class-DK">Death Knight</span></a></li>
                        </ul>
                    </li>
                    <li><a>Skills</a>
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
            <div class="tutorialPage" id="t_main">
                <h2>Main Goal</h2>
                <p>Dragonchan is a script that converts any /b/ thread into a dragon slaying match<p>
                <p>The script parses the thread using the json API and calculates damage/classes and other skills depending on post rolls, images, replies, etc...</p>
                <p>The main goal is to kill a dragon (or any other boss) by roleplaing on /b/ posting your hits and skills and checking the script page for damage output and fight status</p>
                <p>The game focus on cooperation, as every class depends on eachother for its full benefit, this is why we implemented a diferent set of classes and skills and balanced them in a co-dependent way.</p>
                <p>Using your class specific skills you can help eachother in the quest of defeating the dragon. if cooperation is not achived the thread will simply die by itself...</p>
            </div>
            <div class="tutorialPage" id="t_roll">
                <h2>What is a roll?</h2>
                <p>
                    A roll consilts on the last 2 digits of your post number. ocasionaly, some skills will use the last 2 digits of the id generated to any image you post.
                </p>
                <p>
                    Rolls are calculated in a way that they allways return a >0 number, this means that if your last 2 digits are "00" the script will look for your last 3 digits. if you last 3 digits are still "000", the script will look for your last 4 digits. this will go on until a >1 digit is found.
                </p>
                <p>
                    Sometimes people are going to burst >1000 damage in one go, this is becouse 00 dubs are disable on /b/ but 000 trips are allowed. the damage for this roll will be from 1000 to 9000 and this is intended. same goes for quads "0000". This is extremely rare but will make some "lucky" rolls enjoyable.
                </p>
                <p>
                    This system is only possible because /b/ has a very very very fast post per second ratio, making the last 2 digits of your post nearly random.
                </p>
            </div>
            <div class="tutorialPage" id="t_id">
                <h2>What is my ID?</h2>
                <p>
                    Your ID is a randomly generated hash that 4chan gives you.
                </p>
                <p>
                    This hash is unique for every thread you enter meaning it will change from thread to thread but not from post to post.This way the script can detect exactly who you are and what have you posted in a thread, thracking the damage for each ID.
                </p>
                <p>
                    Your ID determinates your class. The script assigns you a class and becouse IDs are persistent only inside the same thread this class will change the next dragonraid thread you enter.
                </p>
                <p>
                    All classes are balanced, or at least we try to make them balanced, but some are more common then others. This does not mean some classes suck and others dont. Its just the way the game was designed, making the classes more or less needed.
                </p>
                <hr/>
                <h3>What is my class?</h3>
                <p>
                    The class you get depends on your ID in the current thread, you can check the Rules section to understand the class system.
                </p>
                <ul class="rules">
                    <li>If your ID starts with a number you are a <span class="ink-label class-H">Healer</span>.</li>
                    <li>If your ID starts with a vowel you are a <span class="ink-label class-B">Bard</span>.</li>
                    <li>If your ID starts with a "/" or "+" you are a <span class="ink-label class-P">Paladin</span>.</li>
                    <li>If your ID starts with "W","R","L","C" or "K" you are a <span class="ink-label class-W">Warlock</span>.</li>
                    <li>If your ID has a "+" or "/" in it, you are a <span class="ink-label class-DK">Death Knight</span></li>
                    <li>Otherwise you are a <span class="ink-label class-K">Knight</span></li>
                </ul>
            </div>
            <div class="tutorialPage" id="t_classes">
                <h2>Classes</h2>
                <p>
                    There are currently 6 diferent classes, each with its own habilities
                </p>
                <h4>Suport</h4>
                <ul>
                    <li><span class="ink-label class-H">Healer</span> can revive other players.</li>
                    <li><span class="ink-label class-B">Bard</span> will boost other people damage by posting images</li>
                </ul>
                <h4>Damage</h4>
                <ul>
                    <li><span class="ink-label class-W">Warlock</span> can summon diferent creatures for aditional damage</li>
                    <li><span class="ink-label class-K">Knight</span> can avenge fallen soldiers for extra damage</li>
                </ul>
                <h4>Special (rare)</h4>
                 <ul>
                    <li><span class="ink-label class-P">Paladin</span> can avenge AND revive fallen team mates</li>
                    <li><span class="ink-label class-DK">Death Knight</span> can attack after death.</li>
                </ul>

                <hr/>
                <h3>What is my class?</h3>
                <p>
                    The class you get depends on your ID in the current thread, you can check the Rules section to understand the class system.
                </p>

                <ul class="rules">
                    <li>If your ID starts with a number you are a <span class="ink-label class-H">Healer</span>.</li>
                    <li>If your ID starts with a vowel you are a <span class="ink-label class-B">Bard</span>.</li>
                    <li>If your ID starts with a "/" or "+" you are a <span class="ink-label class-P">Paladin</span>.</li>
                    <li>If your ID starts with "W","R","L","C" or "K" you are a <span class="ink-label class-W">Warlock</span>.</li>
                    <li>If your ID has a "+" or "/" in it, you are a <span class="ink-label class-DK">Death Knight</span></li>
                    <li>Otherwise you are a <span class="ink-label class-K">Knight</span></li>
                </ul>
            </div>
            <div class="tutorialPage" id="t_basic">
                <h2>Basic Mechanics</h2>
                <p>The game is very simple. Find a dragonslayer thead and post stuff on it.</p>
                <p>you can use this webpage to track the party damage, but placing the 4chan thread id on this URL</p>
                <div>
                    <img class="ink-l100 ink-m90 ink-s90" src="/images/howtostart.jpg"/>
                </div>
                <h2>Starting a thead</h2>
                <p>
                    To start a new dragon slayer thread <a href="">copy/paste the thead template from the github</a> repo and start a new thead.
                    <br/>
                    Its recomended that you post a link to the script in your second post, so new people can understad the rules and the game itself.
                </p>
                <div>
                    <p class="ink-label warning"> You should allways check the catalog before creating a new thread.</p>
                    <p class="ink-label caution"> don't spam the front page with dragon raid threads!</p>
                </div>
                <h2>The Boss</h2>
                <p>
                    The boss has a radom HP depending on OP roll. this allows for stronger or weaker dragons.
                    The minimum HP is now set to 16.000HP.
                </p>
                <h2>Damage</h2>
                <p>
                    Your is calculated based on your <a href="#t_roll">roll</a>.
                    The script woll output everyone`s damage as well as other actions.
                </p>
                <div>
                    <img class="ink-l100 ink-m90 ink-s90" src="/images/howtolog.jpg"/>
                </div>

                <h2>Death</h2>
                <p>
                    When you roll under 11 you will die. this means your posts will no longer do damage until you are revived. (death knights may cheat death)
                </p>
                <p>
                    Everytime you someone dies, the boss will heal for a small amouth depending on your roll. If you are a healer, try reviving your falled team mates, they will thank you for that.                    
                </p>
                <h2>Enrage</h2>
                <p>
                    When the boss HP drops below 20% he will enrage. the minumum roll will be 22 (if you roll under 22 you die).
                    An enraged boss can not heal himself.
                </p>
                <h2>Victory</h2>
                <p>
                    The game ends when the dragon reaches 0HP.
                    By this time the script will tell you who delivered the last hit. Be noble and congratulate your new hero!
                </p>
                <h2>TOP</h2>
                <p>
                   The script keeps a sidebar with diferent TOP10 lists so you can track the raid overall effectiveness.
                   <br/>
                   Allways keep an eye on the top damage, your ID might be there!
                </p>
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
            $(tab).show();
            $('.tutorialMenu a').parent().removeClass('active');
            $(this).parent().addClass('active');
        });
        
        $('.tutorialPage').hide(function(){
            $('#t_main').show();
        });

    });
</script>

<hr/>