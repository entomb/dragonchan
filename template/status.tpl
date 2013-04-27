<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="http://css.ink.sapo.pt/v1/css/ink.css" />
        <title>Status Panel</title>
        <link href="site.css" rel="stylesheet" type="text/css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <style type="text/css">
    
        .ink-row{
            font-size:.8em;
        }
        h3{
            font-size:1.2em;
        }
        .ink-button{
            font-size:1.2em;
        }
        </style>
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
                        }

                        if(newHP<500){
                            interval=1;
                        }

                        if(interval>5){
                            interval = 5;
                        }

                        setTimeout('refreshData()',800*interval);
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
