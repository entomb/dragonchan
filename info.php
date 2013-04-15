<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="http://css.ink.sapo.pt/v1/css/ink.css" />
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
        span.ink-label.class-K{
            background-color: #59A6AE;
        }
        span.ink-label.class-H{
            background-color: #FAA57C;
        }
        </style>
    </head>
    <body>
        <div class="ink-container">

        <h2>chan Boss Raid <small>version 1</small></h2>
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
                        <li>otherwise you are a <b>Knight</b></li>
                        <li>Your last 2 digits represent the damage you do</li>
                        <li>if <b>Knight</b> Roll ends in 5 or 0 you do DOUBLE DAMAGE</li>
                        <li>If you roll under 11 you DIE! <i style="font-size:11px;">(your posts will no longer do damage)</i></li>
                        <li><b>Healers</b> can revive fallen soldiers by targeting them and rolling 0 or 5</li>
                        <li><b>Knights</b> can avenge fallen soldiers by targeting them and rolling 0 or 5</li>
                        <li>you can be avenged/revived 3 times max</li>
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
                <h4>v1 - 15-04-2013</h4>
                    <ul>
                    <li>Class system. Knights and Healers</li>
                    <li>New target systems. </li>
                    <li>knights target for more damage</li>
                    <li>Healers target for revive</li>
                    <li>Max 3 targets</li>
                    <li>boss will enrage when bellow 20% HP</li>
                    <li>boll will heal for every kill he does</li>
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
    </body>
</html>