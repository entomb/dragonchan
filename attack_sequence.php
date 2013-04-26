<tr>
    <td>
        <a target="_blank" href="<?php echo $_row['link']; ?>">
            &gt;&gt;<?php echo $_row['post']; ?>
        </a>
    </td>

    <td class="class-<?php echo $_row['class']; ?>-sprite" width="55">
        <img src="images/sprites/rpg/armor/<?php echo $_row['sprite']; ?>" />
        <img src="images/sprites/rpg/weapons/<?php echo $_row['weapon']; ?>" />
    </td>
    <td style="font-size:13px;" width="100">
        <span class="ink-label class-<?php echo $_row['class']; ?>"><?php echo $_row['class']; ?></span>
        <span class="ink-label class-<?php echo $_row['class']; ?>">
            <?php echo $_row['id']; ?>
        </span>
    </td>

    <td class="<?php echo($_row['action']) ?>">
        <?php
            $_damage = $_row['damage'];
            $_bonus  = $_row['bonus'];
            $_roll   = $_row['roll'];
            $_class  = $_row['class'];

            switch ($_row['action']) {
                case 'damage':
                    if($_bonus>0){
                        echo "<img src='images/sprites/rpg/attack_up.png' />";
                        if($_row['chosen_element'] != "normal" && $_row['class'] == "W") { ?> <img src="images/sprites/rpg/elements/summon.png" title="Summon" />, summons an (<?php echo strtoupper($_row['chosen_element']); ?> <img src="images/sprites/rpg/elements/<?php echo $_row['chosen_element']; ?>.png" title="<?php echo $_row['chosen_element']; ?>"> Golem),
                        <?php } elseif($_row['chosen_element'] == "normal" && $_row['class'] == "W") { ?> <img src="images/sprites/rpg/elements/summon.png" title="Summon" />, summons an (IMP),
                        <?php }
                        echo " <i>rolls $_roll</i> and damages the beast for <span class='ink-label caution'>".($_damage+$_bonus)."<small>(+$_bonus)</small> HP</span>";
                    }elseif($_bonus<0){
                        echo "<img src='images/sprites/rpg/attack_down.png' /> <i>rolls $_roll</i> and damages the beast for <span class='ink-label caution'>".($_damage+$_bonus)." <small>($_bonus)</small> HP</span>";
                    }else{
                        echo "<i>rolls $_roll</i> and damages the beast for <span class='ink-label caution'>$_damage HP</span>";
                    }
                break;
                case 'death':
                    if($_damage==0){
                        echo "<img src='images/sprites/rpg/death.png' /> dies by rolling $_roll";
                    }else{
                        echo "<img src='images/sprites/rpg/death.png' /> dies by rolling $_roll. the beast heals for <span class='ink-label warning'>".(-$_damage)." HP</span>";
                    }
                break;
                case 'avenge':
                    if($_bonus>0){
                        echo "<img src='images/sprites/rpg/avenge.png' /> avenges <b>".$_row['target']."</b> for extra damage <span class='ink-label caution'>".($_damage+$_bonus)." <small>(+$_bonus)</small> HP</span>";
                    }else{
                        echo "<img src='images/sprites/rpg/avenge.png' /> avenges <b>".$_row['target']."</b> for extra damage <span class='ink-label caution'>$_damage HP</span>";
                    }

                break;
                case 'revive':
                    echo "<img src='images/sprites/rpg/phoenix_down.png' /> revives <b>".$_row['target']."</b> by rolling $_roll";
                break;
                case 'massrevive':
                    echo "<span class='ink-label success'>REVIVES EVERYONE!</span>";
                break;
                case 'winrar':
                    echo "<span class='ink-label success'>IS THE NEW HERO!</span>";
                break;
                case 'buff':
                    echo "<img src='images/sprites/rpg/song.png' /> sings the bard song and boosts next 3 hits for <span class='ink-label caution' style='background-color:#F49D9D'>+".$_row['bonus']."</span>";
                break;
            }

        ?>
    </td>
</tr>
