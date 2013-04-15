<?php
//4chan dragon raid
error_reporting(E_ALL);

$thread_id = (int)$_GET['id'];
$api_url   = "http://api.4chan.org/b/res/$thread_id.json";

try{
    $JSON = file_get_contents($api_url);
    $THREAD = json_decode($JSON);
}catch(Exeption $e){
    exit("that is not a valid 4chan thead id...");
}

if(!isset($THREAD->posts) || count($THREAD->posts)<1){
    exit("that is not a valid 4chan thead id...");
}

/*
include("dragonraid.php");

$Raid = new DragonRaid($THREAD);
$Raid->play();
$Raid->display();
exit();
*/

//assign OP status
$firstPost = $THREAD->posts[0];
$OP = $firstPost->id;

//dragon
//$dImg = "http://images.4chan.org/b/src/".$firstPost->tim.$firstPost->ext;
$dImg = "http://0.thumbs.4chan.org/b/thumb/".$firstPost->tim."s".$firstPost->ext;
$dHP_max = roll($firstPost->no)*200;
$dHP     = $dHP_max;

$WINNER = array();
$activeKnights = array();
$deadKnights   = array();
$HITS          = array();
$DPS           = array();

function roll($post,$num=2){
    $r = (int)substr($post, strlen($post)-$num,strlen($post));
    while($r==0){
        //dubs dubs dubs
        $r = (int)substr($post, strlen($post)-$num++,strlen($post));
    }
    return $r;
}

function isCrit($num){
    if($num%5 == 0){
        return true;
    }

}

function getTargetsPosts($text){
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

foreach($THREAD->posts as $post){
    if($post->id==$OP) continue;
    if(in_array($post->id, $deadKnights)) continue;
    if($dHP<=0) continue;

    $activeKnights[] = $post->id;
    $_link = "http://boards.4chan.org/b/res/".$thread_id."#p".$post->no;
    $post->link = $_link;
    $_roll = roll($post->no,2);

    if($_roll>99){
        $deadKnights=array();
        $HITS[] = array(
                    'link'   => $_link,
                    'post'   => $post->no,
                    'id'     => $post->id,
                    'roll'   => $_roll,
                    'damage' => 'revive',
                );
        $HITS[] = array(
                    'link'   => $_link,
                    'post'   => $post->no,
                    'id'     => $post->id,
                    'roll'   => $_roll,
                    'damage' => $_roll,
                );
        continue;
    }

    if($_roll<11){
        $deadKnights[]=$post->id;

        $HITS[] = array(
                    'link'   => $_link,
                    'post'   => $post->no,
                    'id'     => $post->id,
                    'roll'   => $_roll,
                    'damage' => 'death',
                );
        continue;
    }


    if(isCrit($_roll)){
        //assign crit damage
       $_damage=($_roll*2);
    }else{
        //assign damage
        $_damage=$_roll;
    }


        $dHP-=$_damage;

    if($dHP<=0){
        $WINNER = $post;
    }



    $HITS[] = array(
                'link'   => $_link,
                'post'   => $post->no,
                'id'     => $post->id,
                'roll'   => $_roll,
                'damage' => $_damage,
            );



}


//dps
foreach($HITS as $_hit){
    if($_hit['damage']=='death') continue;
    if($_hit['damage']=='revive') continue;

    if(!isset($DPS[$_hit['id']])){
        $DPS[$_hit['id']] = 0;
    }
    $DPS[$_hit['id']]+= (int)$_hit['damage'];

}

arsort($DPS);
$DPS = array_slice($DPS,0,10,true);


array_unique($activeKnights);
array_unique($deadKnights);
$HITS = array_reverse($HITS);
$deadKnights= array_reverse($deadKnights);
?>
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
        td{
            padding:3px;
        }
        </style>
    </head>
    <body>
        <div class="ink-container">

        <h2>4chan Dragon Raid (<?php echo $thread_id ?>)</h2>
        <div class="ink-row">
            <div class="ink-gutter">
                <div class="ink-l50">
                    <img style="width:300px;" src="<?php echo $dImg;?>">
                </div>
                <div class="ink-l50">
                    <h1>HP: <?php echo $dHP ?>/<?php echo $dHP_max ?></h1>
                    <ul>
                        <li>Your last 2 digits represent the damage you do</li>
                        <li>If Roll ends in 5 or 0 you do DOUBLE DAMAGE</li>
                        <li>If you roll under 11 you DIE! <i style="font-size:11px;">(your posts will no longer do damage)</i></li>
                        <li>If you roll 00 you REVIVE everyone! their damage will count again! </li>
                    </ul>
                </div>
            </div>
        </div>

        <hr/>

        <?php
        if($WINNER){
            echo "<h1 class='hero'>";
            echo "WINRAR!!! Hail the new dragon slayer!";
            echo "<br/>";
            echo '<a target="_blank" href="'.$WINNER->link.'">';
            echo " &gt;&gt;".$WINNER->no;
            echo '</a>';
            echo "&nbsp;&nbsp;";
            echo "<p>";
            echo strip_tags($WINNER->com);
            echo "&nbsp; - <span class='ink-label info' style='font-size:17px;'>";
            echo $WINNER->id;
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
                    <?php foreach($HITS as $_row){ ?>
                        <tr>
                            <td>
                                <a target="_blank" href="<?php echo $_row['link']; ?>">
                                    &gt;&gt;<?php echo $_row['post']; ?>
                                </a>
                            </td>
                            <td style="font-size:13px;"><span class="ink-label info"><?php echo $_row['id'] ?></span></td>
                            <?php if($_row['damage']=="death"){ ?>
                            <td class="death"><?php echo "dies by rolling ".$_row['roll'] ?></td>
                            <?php }elseif($_row['damage']=="revive"){ ?>
                            <td class="revive"><span class="ink-label success"><?php echo "REVIVES EVERYONE!"; ?></span></td>
                            <?php }else{ ?>
                            <td class="hit"><?php echo " <i>rolls ".$_row['roll']."</i> and hits the dragon for <span class='ink-label caution'>".$_row['damage']." HP</span>" ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                    </table>

                </div>
                <div class="ink-gutter ink-l20">
                    <h3>TOP DAMAGE</h3>
                     <?php foreach($DPS as $_id => $_damage){
                     echo "<span class='ink-label caution'>".$_damage." HP</span>";
                     echo "&nbsp;<b>".$_id."</b>";
                     echo "<br/>";
                     } ?>

                    <h3>Fallen Knights</h3>
                     <?php foreach($deadKnights as $_row){
                     echo "&#x271D;";
                     echo " <i>".$_row."</i>";
                     echo "<br/>";
                     } ?>
                </div>
            </div>
        </div>



        </div>
    </body>
</html>