

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
                        <ul style="padding-left:20px;">
                            <li><a href="#c_healer"><span class="ink-label class-H">Healer</span></a></li>
                            <li><a href="#c_bard"><span class="ink-label class-B">Bard</span></a></li>
                            <li><a href="#c_warlock"><span class="ink-label class-W">Warlock</span></a></li>
                            <li><a href="#c_ranger"><span class="ink-label class-R">Ranger</span></a></li>
                            <li><a href="#c_knight"><span class="ink-label class-K">Knight</span></a></li>
                            <li><a href="#c_paladin"><span class="ink-label class-P">Paladin</span></a></li>
                            <li><a href="#c_deathknigh"><span class="ink-label class-DK">Death Knight</span></a></li>
                            <li><a href="#c_dragonborn"><span class="ink-label class-DVK">DragonBorn</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#t_elements">Elements</a></li>
                    <li><a href="#t_special">Special Rolls</a></li>
                    <li><a href="#t_commands">Commands</a></li>
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
                    There are currently 8 diferent classes, each with its own habilities
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
                    <li><span class="ink-label class-K">Ranger</span> is a luck based class, depending on your roll you can hit for a lot</li>
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
                <p>You will be assigned a class based on your ID and the last 2 digits of every post represent the damage you do.
                   <br/>
                   You can use this webpage to track the party damage, by placing the 4chan thread ID after the URL.
                </p>
                <div>
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_start.jpg"/>
                </div>
                <h2>Starting a thead</h2>
                <p>
                    To start a new dragon slayer thread <a target="_blank" href="https://github.com/entomb/dragonchan">copy/paste the thead template from the github repo</a> and start a new thead with the desired boss image.
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
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_log.jpg"/>
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
                    <li><span class="ink-label class-R">Rangers</span> are here luck based class, better roll = better damage!</li>
                    <li><span class="ink-label class-K">Knights</span> can critical hit by rolling 5 or 0</li>
                    <li><span class="ink-label class-K">Knights</span> avenge fallen soldiers by targeting them and rolling an EVEN number. Avenging does more damage for the glory of the fallen mate.</li>
                    <li><span class="ink-label class-P">Paladins</span> can avenge AND revive!</li>
                    <li><span class="ink-label class-W">Warlocks</span> can summon minions by posting an image. The last 2 digits of the image filename will be added to his damage. if his roll last digit matches his minion last digit he BURSTS massive damage. If the Warlock types the words "summon@ice", "summon@fire", "summon@water", "summon@electric", or "summon@earth" in their post, they can summon a minion of the specific element for 1.5x additional minion damage if the Beast is weak to the element. If the element is the same as the Beast, the additional minion damage will do .5x the damage instead.</li>
                    <li><span class="ink-label class-DK">Death Knights</span> can continue attacking after they die. they will do x2 damage when dead but only 2/3 when alive.</li>
                    <li><span class="ink-label class-DVK">DragonBorn</span> can avenge and revive when alive, and will transform into a Death knight after death. this is the ultimate class!</li>
                    <li>you can be avenged/revived 6 times max</li>
                    <li>The elemental grid is: Earth is weak to Ice, Water is weak to Electric, Fire is weak to Water, Electric is weak to Earth, Ice is weak to Fire.</li>
                    <li>If you roll 00 or 69 you REVIVE everyone! their damage will count again! </li>
                    <li>The boss will enrage bellow 20% HP, the minimum roll will be 22. however, he will no longer heal himself </li>
                </ul>
            </div>
            <div class="tutorialPage" id="c_healer" style="display:none;">
                <h2>Healer
                <small class="note"> ID starts with a number (0 1 2 3 4 5 6 7 8 9)</small></h2>

                <p>
                    Healers are suport characters. they have the habiliy to revive fallen soldiers.
                </p>
                <h3>How to Revive</h3>
                <p>
                    To revive a fallen soldier you must target them (by quoting his post) and roll an EVEN number (ends in 0,2,4,6,8).
                </p>

                <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_revive.jpg">
                </div>

                <p>
                    If the healing roll is successfull your targets will be alive again.
                    <br/>If you roll an ODD the revive ability will not trigger.
                    <br/> Your damage will still count either way.
                </p>

                <p>
                    You can target more than one post at once, but a player can only be revived 6 times total. Check the sidebar for "most deaths" and "fallen soldiers" too see who needs a revive.<br/>
                    The target system will only work if you quote the death post, so quoting someone asking for revival will not work unless you find where he died.
                </p>
            </div>
            <div class="tutorialPage" id="c_knight" style="display:none;">
                <h2>Knight
                <small class="note"> ID starts with (QTPSDFGHJZXVBNM) </small></h2>
                <p>
                    Knights are a damage dealing class and also the most common class.
                    <br/>
                    Knights damage output is based on avenging and critical hit chance.
                </p>
                <h3>Critical Hit Chance</h3>
                <p>Knights critical hit if their roll ends in "0" or "5". this means the hit does double damage.</p>
                <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_critical.jpg">
                </div>

                <h3>How to Avenge</h3>
                <p>An avenging strike is a second hit for extra damage, this will allow the knigh to repeat his attack in the name of the fallen ones.</p>
                <p>
                    To avenge a fallen soldier you must target him (by quoting his post) and roll an EVEN number (ends in 0,2,4,6,8).
                </p>
                 <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_avenge.jpg">
                </div>
                <p>
                    If the avenging roll is successfull you will swing your sword once again for every target.
                    <br/>If you roll an ODD the avenge ability will not trigger.
                    <br/>If your roll ends in 0 (critical hit) and you are trying to avenge someone, the avenging strike will also be a critical hit.
                </p>
                <p>
                    You can target more than one post at once, but a player can only be avenged 6 times total. Check the sidebar for "fallen soldiers" too see who can be avenged.<br/>
                    The target system will only work if you quote the death post, so quoting someone asking for revival will not work unless you find where he died.
                </p>
            </div>

            <div class="tutorialPage" id="c_paladin" style="display:none;">
                <h2>Paladin
                <small class="note"> ID starts with (+ or /) </small></h2>
                <p>
                    Paladins are holy knights that can heal and avenge fallen soldiers.
                    <br/>
                </p>

                <h3>Holy Light</h3>
                <p>Paladins can shine the holy ligh upon a dead soldier, this will revive AND avenge at the same time, puting the fallen soldier back in the game and dealing extra damage.</p>
                <p>When a paladin revives, same rules apply as if he was a healer</p>
                <p>When a paladin avenges, same rules apply as if he was a knight</p>
                <p>Paladins can NOT critical hit.</p>

                <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_paladin.jpg">
                </div>

                <h3>How to Revive</h3>
                <p>
                    To revive a fallen soldier you must target them (by quoting his post) and roll an EVEN number (ends in 0,2,4,6,8).
                </p>

                <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_revive.jpg">
                </div>

                <p>
                    If the healing roll is successfull your targets will be alive again.
                    <br/>If you roll an ODD the revive ability will not trigger.
                    <br/> Your damage will still count either way.
                </p>

                <p>
                    You can target more than one post at once, but a player can only be revived 6 times total. Check the sidebar for "most deaths" and "fallen soldiers" too see who needs a revive.<br/>
                    The target system will only work if you quote the death post, so quoting someone asking for revival will not work unless you find where he died.
                </p>


                <h3>How to Avenge</h3>
                <p>An avenging strike is a second hit for extra damage, this will allow the knigh to repeat his attack in the name of the fallen ones.</p>
                <p>
                    To avenge a fallen soldier you must target him (by quoting his post) and roll an EVEN number (ends in 0,2,4,6,8).
                </p>
                <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_avenge.jpg">
                </div>
                <p>
                    If the avenging roll is successfull you will swing your sword once again for every target.
                    <br/>If you roll an ODD the avenge ability will not trigger.
                </p>
                <p>
                    You can target more than one post at once, but a player can only be avenged 6 times total. Check the sidebar for "fallen soldiers" too see who can be avenged.<br/>
                    The target system will only work if you quote the death post, so quoting someone asking for revival will not work unless you find where he died.
                </p>
            </div>
            <div class="tutorialPage" id="c_deathknigh" style="display:none;">
                <h2>Death Knight
                <small class="note"> ID ends with (+ or /) </small></h2>
                <p>
                    Death knights are undead demons without a soul that can continue attacking after death.
                    <br/>
                </p>
                <p>
                    Death knights are more powerfull after they die, they will do DOUBLE damage when dead but only 2/3 damage when alive.
                </p>
                <p>Healers should be carefull not the revive them, as they are way more valuable when dead.</p>
            </div>
            <div class="tutorialPage" id="c_dragonborn" style="display:none;">
                <h2>DragonBorn
                <small class="note"> ID starts and ends with (+ or /) </small></h2>
                <p>
                    DragonBorns are a very rare and special class. They can avenge and revive when they are alive, and they transfom into a death knight when dead allowing them to continue attacking with bonus damage.
                    <br/>
                </p>
                <p>DragonBorns use their power on fallen soldiers to revive AND avenge at the same time, puting the fallen soldier back in the game and dealing extra damage.</p>
                <p>When a DragonBorn revives, same rules apply as if he was a healer</p>
                <p>When a DragonBorn avenges, same rules apply as if he was a knight</p>
                <p>DragonBorn can NOT critical hit.</p>
                <p>After they die, DragonBorns can continue attacking but will not be able to avenge/revive until they are alive again</p>
                <p>When a dead DragonBorn attacks, he will do DOUBLE damage</p>
            </div>
            <div class="tutorialPage" id="c_bard" style="display:none;">
                <h2>Bard
                <small class="note"> ID starts with a vowel (A E I O U) </small></h2>
                <p>
                    Bards are a support class and every time they post an image the next 3 posts will do bonus damage.
                    <br/>
                </p>
                <h3>The bard song</h3>
                <p>
                    Bards can should allways post images to boost troop morale.
                    <br/>
                    Bards are importat to boost other people damage output as the bonus will be equal to 1/3 of their roll and lasts for 3 turns.
                    Higher rolls for bards mean higher damage for the whole party.
                </p>
                <p>
                    The bonus is visible on the battle log and on every attack that benefits from it.
                </p>
                <p><b>Bard buffs stack</b> with each other and with every other bonus!</p>
                <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_bard.jpg">
                </div>

            </div>
            <div class="tutorialPage" id="c_ranger" style="display:none;">
                <h2>Ranger
                <small class="note"> ID starts with XYZ </small></h2>
                <p>
                    Rangers are a luck based class, they can hit for a lot or miss completly.
                    <br/>
                </p>
                <h3>The Rolls</h3>
                <p>
                    Your last digit will determinate how much damage you do.
                </p>
                <ul>
                    <li>0 = <b style="font-size:1em">1x</b> damage</li>
                    <li>1 = <b style="font-size:1em">1x</b> damage</li>
                    <li>2 = <b style="font-size:1.2em">2x</b> damage</li>
                    <li>3 = <b style="font-size:1.3em">3x</b> damage</li>
                    <li>4 = <b style="font-size:1.4em">4x</b> damage</li>
                    <li>5 = <b style="font-size:1.5em">5x</b> damage</li>
                    <li>6 = <b style="font-size:1.4em">4x</b> damage</li>
                    <li>7 = <b style="font-size:1.3em">3x</b> damage</li>
                    <li>8 = <b style="font-size:1em">1x</b> damage</li>
                    <li>9 = <b style="font-size:1em">0x</b> damage</li>
                </ul>
            </div>
            <div class="tutorialPage" id="c_warlock" style="display:none;">
                <h2>Warlock
                <small class="note"> ID starts with (W R L C K) </small></h2>
                <p>
                    Warlocks are a damage dealing class that can summon minions for bonus damage.
                    <br/>
                </p>
                <p>Warlocks have the power to conjure monions by posting an image. the minion power is calculated by the roll of the generated filename.</p>
                <p>Warlocks will critical hit if the minion last digit matches their roll last digit.</p>

                <h3>How to Summon</h3>
                <p>
                    To summon a minion simply post an image. The image filename roll will be added to your damage as a bonus.
                    <br/>
                    If a minion rolls trips or quads, that many damage is added.
                </p>
                <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_summon.jpg">
                </div>
                <h3>Elemental Damage</h3>
                <p>
                    You can summon 6 diferent minions by typing diferent commands in your post:
                    <ul>
                        <li><span class="ink-label e_normal"> <img align="absmiddle" src='images/sprites/rpg/elements/summon.png'> IMP </span> - default summon</li>
                        <li><span class="ink-label e_water"> <img align="absmiddle" src='images/sprites/rpg/elements/water.png'> WATER golem</span> - type 'summon@water' in your post</li>
                        <li><span class="ink-label e_fire"> <img align="absmiddle" src='images/sprites/rpg/elements/fire.png'> FIRE golem</span> - type 'summon@fire' in your post</li>
                        <li><span class="ink-label e_ice"> <img align="absmiddle" src='images/sprites/rpg/elements/ice.png'> ICE golem</span> - type 'summon@ice' in your post</li>
                        <li><span class="ink-label e_earth"> <img align="absmiddle" src='images/sprites/rpg/elements/earth.png'> EARTH golem</span> - type 'summon@earth' in your post</li>
                        <li><span class="ink-label e_electric"> <img align="absmiddle" src='images/sprites/rpg/elements/electric.png'> ELECTRIC golem</span> - type 'summon@electric' in your post</li>
                    </ul>
                    <br/>
                    If you summon the correct element, your summon will be more powerful.
                    <br/>
                    You can only assign 1 element per post, so if you type more than one only the first one will be considered.
                    <br/>
                    The bonus and element are visible on the battle log.
                </p>
                <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_summon_element.jpg">
                </div>
                <h3>Burst Damage</h3>
                <p>Warlocks will critical hit if the minion last digit matches their roll last digit. This is called burst damage and it will greatly increase the minion's power.</p>
                <p>Burst damage stacks with elemental bonus!</p>
                <p>If a minion rolls trips or quads, that many damage is added, but the burst damage is not applied.</p>
                <div class="ink-vspace">
                    <img class="ink-l100 ink-m90 ink-s90" src="images/howto_summon_burst.jpg">
                </div>
            </div>
            <div class="tutorialPage" id="t_elements" style="display:none;">
                <h2>Elements
                <small class="note"> (beta) </small></h2>
                <p>
                    Elements are a new mechanic introduced on version 1.6
                </p>
                <p>The new bosses have a randomly generated element, and these elements are arranged in a strong/weak table.</p>
                <p>Each element has a weakness.</p>

                <div class="ink-l30 ink-m30 ink-s90">
                    <img class="" src="images/elements.jpg">
                </div>
                <div class="ink-space ink-l50 ink-m50 ink-s90">
                    <ul style="list-style:none;">
                        <li>
                            <span class="ink-label e_fire">FIRE</span> is strong agaist <span class="ink-label e_ice">ICE</span>
                        </li>
                        <li>
                            <span class="ink-label e_ice">ICE</span> is strong agaist <span class="ink-label e_earth">EARTH</span>
                        </li>
                        <li>
                            <span class="ink-label e_earth">EARTH</span> is strong agaist <span class="ink-label e_electric">ELECTRIC</span>
                        </li>
                        <li>
                            <span class="ink-label e_electric">ELECTRIC</span> is strong agaist <span class="ink-label e_water">WATER</span>
                        </li>
                        <li>
                            <span class="ink-label e_water">WATER</span> is strong agaist <span class="ink-label e_fire">FIRE</span>
                        </li>
                    </ul>
                </div>
                <div class="ink-row"></div>
                <p class="note">
                Right now the only class using elements are Warlocks, but soon more classes will interact with them.
                <br/>check this page for updates!
                </p>
            </div>
            <div class="tutorialPage" id="t_special" style="display:none;">
                <h2>Special Rolls</h2>
                <p>Some rolls have special effects.</p>

                <h3>Miss!</h3>
                <p>Some rolls will miss regardless of the roll damage. This is calculated randomly (around 4% chance).</p>

                <h3>Rolling 000 trips, 0000 Quads, 00000 Quints, <small>etc</small></h3>
                <p>Rolls are calculated in a way that they allways return a >0 number, this means that if your last 2 digits are "00" the script will look for your last 3 digits. if you last 3 digits are still "000", the script will look for your last 4 digits. this will go on until a >1 digit is found.</p>
                <p>If you roll a number enting in more than two zeros (000,0000,0000,00000) your roll will give a great amouth of damage.</p>
                <p>This roll will also <span class="ink-label success">REVIVE EVERYONE</span></p>
                <p>All other skills and abilities are ignored (avenges don't work, bonus are not applied, critical hits are not trigered).</p>

                <h3>Rolling 69</h3>
                <p>Rolling a 69 will <span class="ink-label success">REVIVE EVERYONE</span></p>
                <p>Your damage is ignored for this roll</p>
                <p>All other skills and abilities are ignored (avenges don't work, bonus are not applied, critical hits are not trigered).</p>

                <div class="ink-l30 ink-m30 ink-s90">
                    <img class="" src="images/howto_69.jpg">
                </div>
            </div>
            <div class="tutorialPage" id="t_commands" style="display:none;">
                <p>Commands are used to trow some user input to the game, this allows for greater interactivity.</p>
                <p>Commands are used with simple sintax <pre>command@value</pre> </p>

                <h2>OP Commands</h2>
                <p>Will work only on OP first post</p>
                <div class="left-pad">
                    <h3 class="command">difficulty@</h3>
                    <p>Defines the boss dificulty, ranging from very easy to impossible</p>
                    <b>Possible values</b>
                    <ul>
                        <li><pre>difficulty@noob</pre></li>
                        <li><pre>difficulty@easy</pre></li>
                        <li><pre>difficulty@medium</pre></li>
                        <li><pre>difficulty@hard</pre></li>
                    </ul>
                    <h3 class="command">name@</h3>
                    <p>Defines the boss name</p>
                    <b>Variable value</b>
                    <ul>
                        <li><pre>name@[bossname]</pre></li>
                    </ul>
                    <h3 class="command">element@</h3>
                    <p>Defines the boss element</p>
                    <b>Possible values</b>
                    <ul>
                        <li><pre>element@random</pre></li>
                        <li><pre>element@fire</pre></li>
                        <li><pre>element@earth</pre></li>
                        <li><pre>element@water</pre></li>
                        <li><pre>element@ice</pre></li>
                        <li><pre>element@electric</pre></li>
                    </ul>
                    <h3 class="command">health@</h3>
                    <p>Defines the boss manually.</p>
                    <b>Variable value</b>
                    <ul>
                        <li><pre>health@[number]</pre></li>
                    </ul>
                </div>
                <div class="left-pad">
                <h2>Player Commands</h2>
                    <h3 class="command">nickname@</h3>
                    <p>Sets your nickname, you only need to set it once (max length 14 characters)</p>
                    <b>variable value</b>
                    <ul>
                        <li><pre>nickname@[yournick]</pre></li>
                    </ul>
                    <h3 class="command">summon@</h3>
                    <p>Summons a beast of a particular element. See <a href="#c_warlock" class="switch">Warlock - Summon</a> for more information.</p>
                    <b>variable value</b>
                    <ul>
                        <li><pre>summon@[element]</pre></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function(){
        $('.tutorialMenu a, .switch').click(function(){
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
