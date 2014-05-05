<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" media="screen" type="text/css" href="css/style.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="css/bootstrap.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="css/jquery-ui-1.8.23.custom.css" />

        <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <link href='http://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet' type='text/css'>

        <title>GiffyTube</title>

        <script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-35662271-1']);
          _gaq.push(['_trackPageview']);
          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
        </script>
    </head>

    <body>
    	<div class="header">
    		<div class="logo-holder">
                <div class="logo-spacer">
                    <a href="http://giffy-tube.com" class="logo">GiffyTube</a>
                </div>
            </div>
    	</div>
        <div class="container2">
            <img class="gif-output" src="output/<?php echo $_GET['gifurl']; ?>.gif"/>
        </div>
        <!-- <div class="container3">
            
            <div class="meme-holder"><p class="labels">Top Text</p><input type="text" class="meme-text" id="top-text" /></div>
            <div class="clearfix"></div>
            <div class="meme-holder"><p class="labels">Bottom Text</p><input type="text" class="meme-text" id="bottom-text" /></div>
            <div class="clearfix"></div>
            <div class="add-text-button btn" id="addtextbutton">Add Text!</div>

        </div> -->
        <div class="footer">
            <div class="left">
                <!-- About -->
                <!-- Contact -->
            </div>
            <div class="right">
                <!-- shares -->
            </div>
        </div>
        <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4ee8bef447ace6f1"></script>
    </body>
</html>