<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="http://css.ink.sapo.pt/v1/css/ink.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <title>About this page</title>
        <link href="site.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <a target="_blank" href="https://github.com/entomb/dragonchan"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>
        <div class="ink-container">

        <h2>Dragonchan <wb><small>version 1.7</small></h2>
        <?php include('tutorial.tpl'); ?>

        <hr/>

        <div class="ink-row ink-vspace">
            <div class="ink-gutter">
                <div class="ink-l40">
                    <h3>Open Source</h3>
                    <p> Github Project<br/>
                        <a target="_blank" href="https://github.com/entomb/dragonchan">https://github.com/entomb/dragonchan</a>
                    </p>
                    <span class="note"> Have any sugestions? contact us on github!</span>

                    <p> CSS framework: <a target="_blank" href="http://ink.sapo.pt/">Ink</a></p>
                    <p> Hosting: <a target="_blank" href="https://www.appfog.com/">AppFog</a></p>
                    <p> 4chan API: <a target="_blank" href="https://github.com/4chan/4chan-API">Github repo</a></p>
                    <p> Sprites: <a target="_blank" href="http://leon-murayami.deviantart.com/">Leon-Murayami</a></p>

                </div>
                <div class="ink-l60">
                    <h3>Credits</h3>
                    <p> Original Idea and code:<br/>
                        <ul>
                            <li><a target="_blank" href="https://github.com/entomb">entomb</a></li>
                        </ul>
                    </p>


                    <p> New Ideas, game mechanics and code:<br/>
                        <ul>
                            <li><a target="_blank" href="https://github.com/tselaty">tselaty</a></li>
                            <li><a target="_blank" href="https://github.com/RobertsOma">RobertsOma</a></li>
                            <li><a target="_blank" href="https://github.com/Q4-Bi">Q4-Bi</a></li>
                            <li><a target="_blank" href="https://github.com/poisonrune">poisonrune</a></li>
                            <li>Bryan</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>

        <hr/>

        <div class="ink-row">
            <div class="ink-gutter">
                <h3>Changelog</h3>
                <h4>v1.7- 09-07-2013</h4>
                    <ul>
                        <li>New class: 'Ranger'</li>
                    </ul>
                <h4>v1.6.5- 30-04-2013</h4>
                    <ul>
                        <li>Player commands</li>
                        <li>OP commands</li>
                        <li>sprite fix</li>
                    </ul>
                <h4>v1.6- 27-04-2013</h4>
                    <ul>
                        <li>New Class: 'Dragonborn'</li>
                        <li>Code Cleanup and new sprites</li>
                        <li>Changes to death knight damage output</li>
                        <li>Changes to warlock summon system</li>
                        <li>Adding element mechanics</li>
                        <li>Boss minimum HP is not set to 16.000</li>
                    </ul>
                <h4>v1.5- 24-04-2013</h4>
                    <ul>
                        <li>New Classes: 'Death Knight' and 'Warlock'</li>
                        <li>Added memcache so it doesn`t stress the api</li>
                        <li>Replies to the killer blow now display bellow the winner notification</li>
                        <li>Small fixes on the autoupdater CSS</li>
                    </ul>
                <h4>v1.4.5- 22-04-2013</h4>
                    <ul>
                        <li>Massive interface changes</li>
                        <li>new domain: `http://slayer.pw/$THREADID`</li>
                        <li>new domain: `http://dragon.slayer.pw/$THREADID`</li>
                    </ul>
                <h4>v1.4.1- 21-04-2013</h4>
                    <ul>
                        <li>added: Top deaths stats</li>
                        <li>added: Top bard buff stats</li>
                        <li>adjustments to the fight template</li>
                    </ul>
                <h4>v1.4- 20-04-2013</h4>
                    <ul>
                        <li>Added an ajax self updating status panel</li>
                        <li>JS Bookmarklet that opens the status panel on any /b/ thread</li>
                        <li>Fixed bug with bard buff only working on pair number roll</li>
                    </ul>
                <h4>v1.3.1 - 19-04-2013</h4>
                    <ul>
                        <li>added a json export of the current game <i>$THREADID/json</i></li>
                    </ul>
                <h4>v1.3 - 19-04-2013</h4>
                    <ul>
                        <li>New classes: "Paladin" and "Bard"</li>
                        <li>New global bonus damage mechanic (Bard Buff)</li>
                        <li>Added Top Healer and Top Avenger information</li>
                        <li>Max revive now display a row for each resurection</li>
                        <li>Boosted monster HP by a flat 3000</li>
                        <li>Max revive count incresed from 3 to 6</li>
                        <li>Max avenge count incresed from 3 to 6</li>
                    </ul>
                <h4>v1.2 - 19-04-2013</h4>
                    <ul>
                        <li>OP is now a regular player. his posts will no longer be ignored</li>
                    </ul>
                <h4>v1.1 - 16-04-2013</h4>
                    <ul>
                        <li>Incresed chance of avenge/revive</li>
                        <li>Incresed Boss total HP ratio</li>
                    </ul>
                <h4>v1 - 15-04-2013</h4>
                    <ul>
                    <li>Class system. Knights and Healers</li>
                    <li>New target systems. </li>
                    <li>knights target for more damage</li>
                    <li>Healers target for revive</li>
                    <li>Max 3 targets</li>
                    <li>boss will enrage when bellow 20% HP</li>
                    <li>boss will heal for every kill he does</li>
                    <li>69 added to the lucky mass revive roll</li>
                    </ul>
                <h4>v0 - 14-04-2013</h4>
                <ul>
                    <li>First game prototype</li>
                    <li>Last 2 digits represent damage</li>
                    <li>Rolls under 11 die</li>
                    <li>Rolls for 00 will revive everyone</li>
                </ul>
            </div>
        </div>



        </div>
        <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37723000-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
    </body>
</html>
