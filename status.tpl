<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="http://css.ink.sapo.pt/v1/css/ink.css" />
        <title>Status Panel</title>
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
        *{font-size:96%;} 
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="ink-container" style="width:90%">
            <div id="Core">
                <?php include("status_core.tpl"); ?>
            </div>
            <script type="text/javascript">
            $(document).ready(function(){
                var THREAD_ID = '<?php echo $this->THREAD_ID;?>';
                var interval = 1;
                window.refreshData = function(){
                    if($('#bossHP').html()==0){
                        return;
                    }
                    var oldHP = parseInt($('#bossHP').html());


                    $('#Core').load('/'+THREAD_ID+"/ajax",function(){

                        
                        _gaq.push(['_trackEvent', 'Status', 'Call']);

                        var newHP = parseInt($('#bossHP').html()); 
                        if(newHP!=oldHP){
                            interval = 1;
                            $('#bossHP').css({color:'red'}).fadeOut(function(){$(this).fadeIn().css({color:''})});
                        }else{
                            interval++;
                            if(interval>5){
                                interval = 5;
                            }
                        }
                        setTimeout('refreshData()',1000*interval);
                    });
                }
                 setTimeout('refreshData()',1000)
            });
            </script>
        </div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37723000-2']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_trackEvent', 'Status', 'Open']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
    </body>
</html>