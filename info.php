<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="http://css.ink.sapo.pt/v1/css/ink.css" />
        <title>About this page</title>
        <style type="text/css">
        td.death{
            color:#FF706C;
        }
        td.revive{
            color:#59B407;
        }
        td.avenge{
            color:#4395AF;
        }
        td{
            padding:3px;
        }
        .hero{
            background-color: #EEE;
            padding:10px;
            border:2px solid #FEFEFE;
            border-radius: 10px;
        }
        .ink-label small{
            font-size:11px;
            color:#DDD;
        }
        span.ink-label.class-K{
            background-color: #59A6AE;
        }
        span.ink-label.class-H{
            background-color: #FAA57C;
        }
        span.ink-label.class-P{
            background-color: #FCD349;
        }
        span.ink-label.class-B{
            background-color: #EA80D8;
        }
        </style>
    </head>
    <body>
        <div class="ink-container">

        <h2>chan Boss Raid <small>version 1.4</small></h2>
        <div class="ink-row">
            <div class="ink-gutter">
                <div class="ink-l40">
                    <h1>Credits</h1>
                    <p> Github Project<br/>
                        <a target="_blank" href="https://github.com/entomb/dragonchan">https://github.com/entomb/dragonchan</a>
                    </p>

                    <p> Original Idea and code:<br/>
                        <a target="_blank" href="https://github.com/entomb">entomb</a>
                    </p>


                    <p> New Ideas and game mechanics:<br/>
                        Bryan
                    </p>



                    <p> CSS framework: <a target="_blank" href="http://ink.sapo.pt/">Ink</a><p>
                    <p> Hosting: <a target="_blank" href="https://www.appfog.com/">AppFog</a><p>

                </div>
                <div class="ink-l60">
                    <h1>Rules</h1>
                    <ul>
                        <li>If your ID starts with a number you are a <b>Healer</b>.</li>
                        <li>If your ID starts with a vowel you are a <b>Bard</b>.</li>
                        <li>If your ID starts with a "/" or "+" you are a <b>Paladin</b>.</li>
                        <li>otherwise you are a <b>Knight</b></li>
                        <li>Your last 2 digits represent the damage you do</li>
                        <li>if <b>Knight</b> Roll ends in 5 or 0 you do DOUBLE DAMAGE</li>
                        <li>If you roll under 11 you DIE! <i style="font-size:11px;">(your posts will no longer do damage)</i></li>
                        <li><b>Bards</b> are here to motive troops! each time they post an image the next 3 posts will do bonus damage!</li>
                        <li><b>Healers</b> revive fallen soldiers by targeting them and rolling an EVEN number</li>
                        <li><b>Knights</b> avenge fallen soldiers by targeting them and rolling an EVEN number. Avenging does more damage for the glory of the fallen mate.</li>
                        <li><b>Paladins</b> can avenge AND revive!</li>
                        <li>you can be avenged/revived 6 times max</li>
                        <li>If you roll 00 or 69 you REVIVE everyone! their damage will count again! </li>
                        <li>The boss will enrage bellow 20% HP, the minimum roll will be 22. however, he will no longer heal himself </li>
                    </ul>
                </div>
            </div>
        </div>

        <hr/>

        <div class="ink-row">
            <div class="ink-gutter">
                <h3>Changelog</h3>
                <h4>v1.4- 20-04-2013</h4>
                    <ul>
                        <li>Added an ajax self updating status panel</i></li>
                        <li>JS Bookmarklet that opens the status panel on any /b/ thread</i></li>
                        <li>Fixed bug with bard buff only working on pair number roll</i></li>
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