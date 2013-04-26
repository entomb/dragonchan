

<div class="ink-row">
    <div class="ink-gutter">
        <div class="ink-l30">
            <nav class="ink-navigation black">
                <ul class="menu vertical tutorialMenu">
                    <li><h3>How to play</h3></li>
                    <li><a href="#t_main">Main Goal</a></li>
                    <li><a href="#t_roll">What is a Roll?</a></li>
                    <li><a href="#t_id">What is my ID?</a></li>
                    <li><a href="#t_classes">Classes</a>
                        <ul style="padding-left:20px;">
                            <li><a href="#c_knigh"><span class="ink-label class-K">Knight</span></a></li>
                            <li><a href="#c_healer"><span class="ink-label class-H">Healer</span></a></li>
                            <li><a href="#c_bard"><span class="ink-label class-B">Bard</span></a></li>
                            <li><a href="#c_paladin"><span class="ink-label class-P">Paladin</span></a></li>
                            <li><a href="#c_warlock"><span class="ink-label class-W">Warlock</span></a></li>
                            <li><a href="#c_deathknigh"><span class="ink-label class-DK">Death Knight</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#skills">Skills</a>
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
                    Your ID is a randomly generated hash that 4chan gives you. this hash is thread-persistet meaning it will change from thread to thread but not for every post in the same thread. this way the script can detect exactly who you are and what have you posted in a thread, threacking the damage for each diferent ID.
                </p>
                <p>
                    Your ID determinates your class. its not fully random but its a near random hash, using some paramenters we give you a class and becouse IDs are persistent only inside the same thread this class will change the next dragonraid thread you enter.
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
                    <li><span class="ink-label class-W">Warlock</span> can summon diferent creatures to give aditional damage</li>
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
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.tutorialPage').hide();
        $('.tutorialMenu a').click(function(){
            $('.tutorialPage').hide();
            var tab = "#"+this.href.toString().split('#')[1];
            $(tab).show();
        });


    });

</script>

<hr/>