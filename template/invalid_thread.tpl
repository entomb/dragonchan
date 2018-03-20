<!DOCTYPE html>
<html>
    <head>
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <link rel="stylesheet" type="text/css" href="ink.css" />

        <title><?php echo $_gamename;?></title>
        <link href="site.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <a target="_blank" href="https://github.com/entomb/dragonchan"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>
        <div class="ink-container" style="width:90%;">

        <h2><?php echo $_gamename;?></h2>
        <br />
        <div class="ink-row">
            <div class="ink-gutter">
                <div class="ink-l100">
                    <h4>Invalid Thread ID</h4>
                    <p>The thread (#<?php echo $thread_id; ?>) has expired. <a href="http://boards.4chan.org/bant/">Back to /bant/?</a></p>
                </div>
            </div>
        </div>

        </div>
        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-37723000-2']);
          _gaq.push(['_trackPageview']);
          _gaq.push(['_trackEvent', 'Log', 'Invalid']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
    </body>
</html>
