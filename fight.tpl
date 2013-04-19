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

        .sidebar h3{
            padding-top:15px;
        }
        </style>
    </head>
    <body>
        <div class="ink-container">

        <h2>chan Boss Raid (<?php echo $this->THREAD_ID ?>)
            <small><a target="_blank" href="/info">version 1.3.1 (More Info)</a></small>
        </h2>
        <div class="ink-row">
            <div class="ink-gutter">
                <div class="ink-l40">
                    <img style="width:300px;" src="<?php echo $this->BossIMG;?>">
                </div>
                <div class="ink-l60">
                    <h1>HP: <?php echo $this->BossHP ?>/<?php echo $this->BossHP_MAX ?></h1>
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

        <?php
        if($this->WINNER){
            echo "<h1 class='hero'>";
            echo "WINRAR!!! Hail the new monster slayer!";
            echo "<br/>";
            echo '<a target="_blank" href="'.$this->WINNER->link.'">';
            echo " &gt;&gt;".$this->WINNER->no;
            echo '</a>';
            echo "&nbsp;&nbsp;";
            echo "<p style='color:#666;'>";
            echo strip_tags($this->WINNER->com,'<br>');
            echo "&nbsp; - <span class='ink-label info' style='font-size:17px;'>";
            echo $this->WINNER->id;
            echo "</span>";
            echo "</p>";
            echo "</h1>";
        }
        ?>
        <div class="ink-row">
            <div class="ink-gutter">
                <div class="ink-l70">
                    <h3>Last Hits</h3>
                    <table class="ink-table ink-zebra">
                    <?php foreach($BATTLE as $_row){ ?>
                    <?php
                    if($_row['action']=="enrage"){
                        echo "<tr>";
                        echo "<td colspan='3' style='text-align:center; font-size:22px;'>";
                        echo "<span class='ink-label caution'>THE BOSS HAS ENRAGED!</span>";
                        echo "<br/><small>Every roll under $this->min_roll will result in death!!</small>";
                        echo "</td>";
                        echo "</tr>";
                        continue;
                    }
                    ?>
                        <tr>
                            <td>
                                <a target="_blank" href="<?php echo $_row['link']; ?>">
                                    &gt;&gt;<?php echo $_row['post']; ?>
                                </a>
                            </td>
                            <td style="font-size:13px;">
                                <span class="ink-label class-<?php echo $_row['class']; ?>"><?php echo $_row['class']; ?></span>
                                <span class="ink-label info">
                                    <?php echo $_row['id']; ?>
                                </span>
                            </td>

                            <td class="<?php echo($_row['action']) ?>">
                                <?php
                                    $_damage = $_row['damage'];
                                    $_bonus  = $_row['bonus'];
                                    $_roll   = $_row['roll'];

                                    switch ($_row['action']) {
                                        case 'damage':
                                            if($_bonus>0){
                                                echo "<i>rolls $_roll</i> and damages the beast for <span class='ink-label caution'>".($_damage+$_bonus)." <small>(+$_bonus)</small> HP</span>";
                                            }else{
                                                echo "<i>rolls $_roll</i> and damages the beast for <span class='ink-label caution'>$_damage HP</span>";
                                            }
                                        break;
                                        case 'death':
                                            if($_damage==0){
                                                echo "dies by rolling $_roll";
                                            }else{
                                                echo "dies by rolling $_roll. the boss heals for <span class='ink-label warning'>".(-$_damage)." HP</span>";
                                            }
                                        break;
                                        case 'avenge':
                                            if($_bonus>0){
                                                echo "Avenges <b>".$_row['target']."</b> for extra damage <span class='ink-label caution'>".($_damage+$_bonus)." <small>(+$_bonus)</small> HP</span>";
                                            }else{
                                                echo "Avenges <b>".$_row['target']."</b> for extra damage <span class='ink-label caution'>$_damage HP</span>";
                                            }

                                        break;
                                        case 'revive':
                                            echo "Revives <b>".$_row['target']."</b> by rolling $_roll";
                                        break;
                                        case 'massrevive':
                                            echo "<span class='ink-label success'>REVIVES EVERYONE!</span>";
                                        break;
                                        case 'winrar':
                                            echo "<span class='ink-label success'>IS THE NEW HERO!</span>";
                                        break;
                                        case 'buff':
                                            echo "Sings the bard song and boosts next 3 hits for <span class='ink-label caution' style='background-color:#F49D9D'>+".$_row['bonus']."</span>";
                                        break;
                                    }

                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </table>

                </div>
                <div class="ink-gutter ink-l20 sidebar">
                    <h3>TOP DAMAGE</h3>
                     <?php foreach($topDamage as $_id => $_damage){
                     echo "<span class='ink-label caution'>".$_damage." HP</span>";
                     echo "&nbsp;<b>".$_id."</b>";
                     echo "<br/>";
                     } ?>

                    <h3>Top Healers</h3>
                     <?php foreach($topRevive as $_id => $_revives){
                     echo "<span class='ink-label success'>".$_revives." revives</span>";
                     echo "&nbsp;<b>".$_id."</b>";
                     echo "<br/>";
                     } ?>

                    <h3>Top Avengers</h3>
                     <?php foreach($topAvenge as $_id => $_avenges){
                     echo "<span class='ink-label info'>".$_avenges." strikes </span>";
                     echo "&nbsp;<b>".$_id."</b>";
                     echo "<br/>";
                     } ?>

                    <h3>Fallen Soldiers</h3>
                     <?php foreach($this->deadPlayers as $_row){
                     echo "&#x271D;";
                     echo " <i>".$_row."</i>";
                     echo "<br/>";
                     } ?>
                </div>
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