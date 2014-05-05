<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" media="all" type="text/css" href="css/style.css" />
        <link rel="stylesheet" media="all" type="text/css" href="css/bootstrap.css" />
        <link rel="stylesheet" media="all" type="text/css" href="css/jquery-ui-1.8.23.custom.css" />

        <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4ee8bef447ace6f1"></script>
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
        <div class="container">
            <div class="input-holder">
                <input class="textbox" id="URL" type="text" name="URL" onfocus="if(this.value == 'Paste a Youtube video link here...') { this.value = ''; }" value="Paste a Youtube video link here..." />
                <button name="go" id="go" class="buttontext">Go!</button>
            </div>
            <div>
                <div class="controlpanel display-none">
                    <div class="alert">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        Move the sliders to select a range for your gif! The maximum allowed length is 59 seconds!
                    </div>
                    <div class="alert">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        For more precision, select a slider and user the arrow keys!
                    </div>
                    <div id="slider"></div>
                    <div class="innercontainer">
                        <div class="start">
                            <div class="labelholder"><a class="label" id="lbl">START</a></div>
                            <input name="StartTime" id="StartTime" class="startbox box" type="text"/>
                        </div>
                        <div class="video-holder">
                            <div class="video" id="video"></div>
                        </div>
                        <div class="end">
                            <div class="labelholder"><a id="lbl2" class="label endlabel">END</a></div>
                            <input name="Duration" id="Duration" class="endbox box" type="text"/>
                        </div>
                    </div>
                    <div class="clearfix" />
                    <div class="generate-holder">
                        <button id="generate" class="buttontext" name="generate">Generate!</button>
                        <div class="progress prog-bar display-none progress-striped active progress-warning">
                            <div class="bar" style="width: 100%;"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                </div>
            </div>
            <div class="output display-none">
                    <div class="hook"></div>
                    <!-- <img class="gif-output" src="http://lsbehost3.d.umn.edu/Giftest/output/5mfnpirgKNA1350604910.gif" alt="gif output" /> -->


            </div>
        </div>
        <div class="footer">
            <div class="left">
                <!-- About -->
                <!-- Contact -->
            </div>
            <div class="right">
                <!-- shares -->
            </div>
        </div>
    </body>
</html>