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
                case 'miss':
                        sprite('/miss.png');

                        echo "<i>rolls $_roll</i> and misses the beast";
                break;
                case 'damage':
                    if($_bonus>0){
                        sprite('/attack_up.png');

                        if($_row['class'] == "W" && ($_row['_pet_damage'])){
                            if($_row['chosen_element'] == "normal") {
                                sprite("/elements/summon.png");
                                echo "summons an IMP ";
                            }else{
                                sprite("/elements/".$_row['chosen_element'].".png");
                                echo "summons a ".strtoupper($_row['chosen_element'])." Golem ";
                            }
                            echo "with ".$_row['_pet_damage']." power,";
                            echo "<br/>";
                        }
                        echo "<i>rolls $_roll</i> and damages the beast for <span class='ink-label caution'>".($_damage+$_bonus)."<small>(+$_bonus)</small> HP</span>";
                    }elseif($_bonus<0){
                        sprite("/attack_down.png");
                        echo "<i>rolls $_roll</i> and damages the beast for <span class='ink-label caution'>".($_damage+$_bonus)." <small>($_bonus)</small> HP</span>";
                    }else{
                        echo "<i>rolls $_roll</i> and damages the beast for <span class='ink-label caution'>$_damage HP</span>";
                    }
                break;
                case 'death':
                    if($_damage==0){
                        sprite("/death.png");
                        echo "dies by rolling $_roll";
                    }else{
                        sprite("/death.png");
                        echo "dies by rolling $_roll. the beast heals for <span class='ink-label warning'>".(-$_damage)." HP</span>";
                    }
                break;
                case 'avenge':
                    sprite("/avenge.png");
                    if($_bonus>0){
                        sprite('/attack_up.png');
                        echo "avenges <b>".$_row['target']."</b> for extra damage <span class='ink-label caution'>".($_damage+$_bonus)." <small>(+$_bonus)</small> HP</span>";
                    }elseif($_bonus<0){
                        sprite('/attack_down.png');
                        echo "avenges <b>".$_row['target']."</b> for extra damage <span class='ink-label caution'>".($_damage+$_bonus)." <small>($_bonus)</small> HP</span>";
                    }else{
                        echo "avenges <b>".$_row['target']."</b> for extra damage <span class='ink-label caution'>$_damage HP</span>";
                    }

                break;
                case 'revive':
                    sprite("/phoenix_down.png");
                    echo "revives <b>".$_row['target']."</b> by rolling $_roll";
                break;
                case 'massrevive':
                    echo "<span class='ink-label success'>REVIVES EVERYONE!</span>";
                break;
                case 'winrar':
                    echo "<span class='ink-label success'>IS THE NEW HERO!</span>";
                break;
                case 'buff':
                    sprite("/song.png");
                    echo "sings the bard song and boosts next 3 hits for <span class='ink-label caution' style='background-color:#F49D9D'>+".$_row['bonus']."</span>";
                break;
            }

        ?>
    </td>
</tr>
