<div class="ink-row">
    <div class="ink-gutter">
        <div class="ink-l30">
            <b>Dragonchan (<?php echo $this->THREAD_ID ?>)</b>
            <a target="_blank" href="/info">version <?php echo $this->_version;?></a>
            
            <h1>HP: <span id="bossHP"><?php echo $this->BossHP ?></span>/<?php echo $this->BossHP_MAX ?></h1>
            <?php 
            if(!$this->WINNER && $this->bossIsEnraged()){ 
                echo "<span class='ink-label caution'>The best is enraged!</span>";
            }
            ?> 
        </div>
        <div class="ink-l70">  
            <div class="ink-l33 ink-for-l">
                <h3>TOP DAMAGE</h3>
                 <?php foreach($topDamage as $_id => $_damage){
                 echo "<span class='ink-label caution'>".$_damage." HP</span>";
                 echo "&nbsp;<b>".$_id."</b>";
                 echo "<br/>";
                 } ?>
            </div>
            <div class="ink-l66 ink-m100 ink-s100">
                <?php if($this->WINNER){ 
                echo "<h3 class='hero success'>"; 
                echo "The beast has been slain!";
                echo '<a target="_parent" href="'.$this->WINNER->link.'">';
                echo " &gt;&gt;".$this->WINNER->no;
                echo '</a>';
                echo "</h3>";
                } ?>
                <a target="_blank" class="ink-button" href="../<?php echo $this->THREAD_ID;?>">
                    see the full battle log
                </a>
                <a target="_blank" class="ink-button" href="../info">
                    see the rules
                </a>
            </div>
        </div>
    </div>
</div>
