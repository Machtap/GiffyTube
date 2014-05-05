// /* Document Information
// - Version:  1.0
// - Andrew Macht
// */

var youTubePlayer;
var params = { allowScriptAccess: "always" };
var atts = { id: "myvideo" };
var UID = "";
var GifName = "";
var qs = getQueryStrings();

$(document).keypress(function(e){
    if (e.which == 13){
        $("#go").click();
    }
});
$(function addText(){
    $("#addtextbutton").click(function () {
        var topText = $("#top-text").val();
        var bottomText = $("#bottom-text").val();
        var UID = qs["gifurl"];

        alert(topText + " " + bottomText + " " + UID);

        $.post("textadd.php", {
                TT: topText,
                BT: bottomText,
                UID: UID,
            }, function (data1) {
                //alert(data1);
                var G = (data1);
                var UID = G.substring(0,11);
                window.location = "/giffytube/output/gifimages/"+ G + "/" + UID +".gif";
            });
    });
});
$(function createVideo(){
    $("#go").click(function () {
        var U = $("#URL").val();
        $.post("download.php", {
                UID: U
            }, function (data) {
 
            });

        var video_id = U.split('v=')[1];
        var ampersandPosition = video_id.indexOf('&');

        if(ampersandPosition != -1) {
          video_id = video_id.substring(0, ampersandPosition);
        }
        if (U == null || U == "") {
            alert("Input a Video ID");
        }
        UID = video_id;
        swfobject.embedSWF('http://www.youtube.com/v/' + UID + '?enablejsapi=1&version=3', 'video', 560, 315, "9", null, null, params, atts);
        $(".controlpanel").addClass("display-all");
        $(".controlpanel").removeClass("display-none");
    });
});
$(function fireGenerate() {

    $("#generate").click(function () {
        $(".prog-bar").addClass("display-all");
        $(".prog-bar").removeClass("display-none");
        $("#generate").addClass("display-none");

        var URL = $("#URL").val();
        var StartTime = $("#StartTime").val();
        var EndTime = $("#Duration").val();

        var a = StartTime.split(':');
        var b = EndTime.split(':');
        var aa = (+a[0]) * 60 + (+a[1]);
        var bb = (+b[0]) * 60 + (+b[1]);
        var D = bb - aa;

        $.post("run.php", {
            S: StartTime,
            D: D,
            UID: URL
        }, function (data) {
            var G = (data);
            window.location = "display.php?gifurl=" + G;
        });
    });   
});
function makeSomeTime(seconds) {
    var hours = Math.floor(seconds / (60 * 60));
    var div_for_min = seconds % (60 * 60);
    var min = Math.floor(div_for_min / 60);
    var div_for_sec = div_for_min % 60;
    var seconds = Math.ceil(div_for_sec);
    if (seconds < 10) { seconds = "0" + seconds; }
    return min + ":" + seconds;
}
function getQueryStrings() { 
  var assoc  = {};
  var decode = function (s) { return decodeURIComponent(s.replace(/\+/g, " ")); };
  var queryString = location.search.substring(1); 
  var keyValues = queryString.split('&'); 

  for(var i in keyValues) { 
    var key = keyValues[i].split('=');
    if (key.length > 1) {
      assoc[decode(key[0])] = decode(key[1]);
    }
  } 

  return assoc; 
} 
function onYouTubePlayerReady(playerId) {
    youTubePlayer = $("#myvideo").get(0);
    $(".startbox").val("00:00");
    $(".endbox").val(makeSomeTime(30));
    $(function () {
        // Slider
        $('#slider').slider({
            range: true,
            min: 0,
            max: youTubePlayer.getDuration(),
            values: [0, 30],
            slide: function (event, ui) {
                $(".startbox").val(makeSomeTime($(this).slider("values", 0)));
                $(".endbox").val(makeSomeTime($(this).slider("values", 1)));

                var s = $(this).slider("values", 0);
                youTubePlayer.seekTo(s,true);

                $('#slider').bind('slide', function(event, ui) {
                    var a = $(".startbox").val();
                    var b = $(".endbox").val();
                    var c = a+30;
                });
            }
        });
    });
}