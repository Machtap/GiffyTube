var startTime = 0;
var endTime = 0;
var repeatTime = 0;
var startLabel;
var endLabel;
var lastInterval = 0;
var player;
var PLAYER_PADDING_LEFT = 8;
var PLAYER_PADDING_RIGHT = 8;
var pwidth;
var widthTimeRatio = 0.0;
var BEFORE_START = 0;
var BEFORE_END = 1;
var REPEATING = 2;
var status = BEFORE_START;
var POLLING_INTERVAL = 100;
var $startLabel;
var $endLabel;
var params = { allowScriptAccess: "always", allowFullScreen: true, wmode: "transparent" };
var atts = { id: "ytplayer"};
var playerWithControlsHeight;

var $feedView;
var $player;
$(function(){


	$startLabel = $("#startLabel");
	$endLabel =$("#endLabel");
	$("#loadButton").click(load);
	
		
	swfobject.embedSWF("http://www.youtube.com/v/" + defaultVideo + "?version=3&enablejsapi=1&playerapiid=ytplayer", 
	                   "ytplayer", "650", "385", "8", null, null, params, atts);


	$("#tabs").tabs();
	
	$("#search").focus(showFeed).keyup(showFeed)
				//.blur(function(){
				//	setTimeout(function(){$feedView.hide()}, 200);
				//});

	$("#searchButton").click(function(){showFeed($("#freeSearch").val());});

	$player = $("#ytplayer");

	$feedView = $("<ul/>").attr("id", "feedView").hide()
	$(document.body).append($feedView);

	$("#feedView li:not(#searching)").live("click", function(){
		cancel();
		player.loadVideoById(this.id);
		newVideo(this.id);
		widthTimeRatio = 0;
		$feedView.hide();
		$feedView.offset({top: -1000, left:-1000})
		$("title").text($(this).find(".title").text() + " - LoopTheTube");
		return false;
		
	})	
	
	$(window).resize(function(){
		$feedView.offset({top: $player.offset().top, left: $player.offset().left})	
		repositionLabels();
	})
	
	$(document.body).bind("mousedown", function(e){
		if($feedView.is(":visible")){
			if(!($feedView[0] == e.target ||
				e.target == $("#search")[0] || 
				$.contains($feedView[0], e.target))){
				$feedView.hide()
				$feedView.offset({top: -1000, left:-1000})
			}			
		}
	})
	
	
	
	//preload images
	markers = new Image();
	markers.src = "images/markers.gif";
	bg = new Image();
	bg.src = "images/barBG.png";	
	/*
	$("#startLabel, #endLabel").select(function(){return false;})
	   						   .mousedown(function(){
		
		player.pauseVideo();
		$label = $(this);
		
		var minX = $player.offset().left + 1;
		var maxX = $player.offset().left + $player.width() - 3 ;
		$(document.body).bind("mousemove", function(e){
							if(e.pageX >= minX && e.pageX <= maxX){
								$label.offset({left: e.pageX});
							}
			  			})
			  			.bind("mouseup", function(){
							$(this).unbind("mousemove")
						});
		
		
		return false;
	})
	*/
	
	
	
})
		   

function calculateTime2PixelRation(){
	if ((!widthTimeRatio) || widthTimeRatio == Infinity) widthTimeRatio = parseFloat(pwidth - PLAYER_PADDING_LEFT - PLAYER_PADDING_RIGHT) / player.getDuration();
}		
		
function repeatPressed(){ 

	calculateTime2PixelRation();

	if(lastInterval){clearInterval(lastInterval); lastInterval=0;}
	
	if(status == BEFORE_START){
		status = BEFORE_END;
		this.value = "Loop";					
		startTime = player.getCurrentTime();
		setStart(startTime);

	} else if (status == BEFORE_END) {
		status = REPEATING;
		this.value = "Cancel";
		endTime = player.getCurrentTime();
		repeatTime = endTime - startTime;	
	    setEnd(endTime, repeatTime);
		if(lastStart && lastEnd){
			$("#shareURL").val("http://loopthetube.com#" + (lastVideoID ? lastVideoID : defaultVideo) + "&start=" + lastStart + "&end=" + lastEnd);
			//$("#share").css("visibility", "visible");
		}
		repeat();
	} else if (status == REPEATING) {
	
		cancel();

	}

}

firstLoad = true;

function setLoopFromURL(){
	
	if(firstLoad){
		firstLoad = false;
	} else {
		return;
	}
	
	var params =window.location.hash.replace("#","").split("&");

	if (params.length == 3){
		//lastVideoID = params[0];
		startTime = params[1].split("rt=").length == 2?  Number(params[1].split("rt=")[1]) : null;
		endTime = params[2].split("nd=").length == 2? Number(params[2].split("nd=")[1]) : null;
	}

	if (!(lastVideoID && startTime && endTime)){
		return;
	}
	calculateTime2PixelRation();
	status = REPEATING;
	loopButton.value = "Cancel";
	setStart(startTime)
	repeatTime = endTime - startTime;	
    setEnd(endTime, repeatTime);
	if(lastVideoID && lastStart && lastEnd){
		$("#shareURL").val("http://loopthetube.com#" + lastVideoID + "&start=" + lastStart + "&end=" + lastEnd);
		//$("#share").css("visibility", "visible");
	}
	repeat();
}

function cancel(){
	//$("#share").css("visibility", "hidden");
	loopButton.value = "Set Loop Start Point";
	status = BEFORE_START;
	$startLabel.hide();
	$endLabel.hide();
	$bar.hide();
	if(lastInterval){clearInterval(lastInterval); lastInterval=0;}		
}


var doSetTimeout = false;
function repeat(){										
	
	if(endTime <= startTime){
		cancel();
	} else {
		player.seekTo(startTime -1, true);
		timeLeftMS = (endTime * 1000) - (player.getCurrentTime() * 1000);									
		lastInterval = setInterval(poll, POLLING_INTERVAL);					
	}	


}


var loopButton;
var tiplink;

function onYouTubePlayerReady(playerid){
	loopButton = document.getElementById("rbtn");
	loopButton.onclick = repeatPressed;
	loopButton.disabled = true;
	player = document.getElementById(playerid);	
	player.addEventListener("onStateChange"	, "onytplayerStateChange");
	resetMeter();
	playerWithControlsHeight = $("#speed").offset().top + $("#speed").outerHeight() - $player.offset().top;	
	
	if(window.location.hash){
		player.loadVideoById(window.location.hash.replace("#",""));
		lastVideoID = window.location.hash.replace("#","");
		$("#shareURL").val("http://loopthetube.com#" + lastVideoID);
	}	
	
	setInterval(checkHistoryChanges, 50);
}

var lastFeed = {};
function beforeRequest(request, response ){
	
	var searchQuery =  request.term + " +" + $("#instrument").val() + " +[cover | lesson | practice]"
	var rurl = "http://gdata.youtube.com/feeds/api/videos?q=" + searchQuery + "&alt=json-in-script&max-results=25&v=2&key=AI39si7umylfugaFIJfOcC9mpgtRUODmfm0MPOoCcqrRrAIOFtkcccYZb9D2JGrVjKEAkEtn2WeZxN4QEWUqsL4jubHQmBpKXA";
	

	
	
	$.ajax({
		url: rurl,
		dataType: "jsonp",
		success: function(data) {

			lastFeed =  data;					

			response($.map(data.feed.entry, function(item) {
												return {label: item.title.$t,
														value: item.title.$t}
											}))
			
		}
	})

	
}


var lastSearchTimeout=0;
function showFeed(sterm){
	

	
	if(lastSearchTimeout){clearTimeout(lastSearchTimeout); lastSearchTimeout=0;}
	
	var term;
	var searchQuery;
	var rurl;

	
	if(typeof(sterm) == "string"){
		term = sterm;			
		searchQuery =  sterm;
		rurl = "http://gdata.youtube.com/feeds/api/videos?q=" + searchQuery + "&alt=json-in-script&max-results=25&v=2&key=AI39si7umylfugaFIJfOcC9mpgtRUODmfm0MPOoCcqrRrAIOFtkcccYZb9D2JGrVjKEAkEtn2WeZxN4QEWUqsL4jubHQmBpKXA";					
	} else {
		term = this.value				
		searchQuery =  term + " +" + $("#instrument").val() + " +[cover | lesson | practice]"
		rurl = "http://gdata.youtube.com/feeds/api/videos?q=" + searchQuery + "&alt=json-in-script&max-results=25&v=2&key=AI39si7umylfugaFIJfOcC9mpgtRUODmfm0MPOoCcqrRrAIOFtkcccYZb9D2JGrVjKEAkEtn2WeZxN4QEWUqsL4jubHQmBpKXA";					
	}
	
	if(term.length >= 3){
		$feedView.empty()
			     .width($player.outerWidth() -2)
				 .height(playerWithControlsHeight)
				 .offset({top: $("#tabs").offset().top + $("#tabs").height(), left: $("#tabs").offset().left})								
				 .show()
				 .append($("<li/>").attr("id", "searching").text("Searching practice videos for " + term));



	    $feedView.offset({top: $("#tabs").offset().top + $("#tabs").height(), left: $("#tabs").offset().left})

		if(typeof(sterm) == "string"){
			getFeed();
		} else {
				lastSearchTimeout = setTimeout(getFeed, 500);
		}
				
	} else {
		$feedView.hide();
		$feedView.offset({top: -1000, left:-1000})
	}

			
	
	
	function getFeed(){
		
		if(lastSearchTimeout){clearTimeout(lastSearchTimeout); lastSearchTimeout=0;}
		
		$.ajax({
			url: rurl,
			dataType: "jsonp",
			success: function(data) {

				$feedView.empty();
				
				for(i=0; i < data.feed.entry.length; i++){
					var entry = data.feed.entry[i];
					createDomEntry(entry, (i % 2));
				}														

			}
		})					
	}	
	

				
}

function createDomEntry(entry, even){

	var $newEntry =
	$("<li/>").append($("<img/>").attr("src", entry.media$group.media$thumbnail[0].url).width(120).height(90))
			  .append($("<div/>").addClass("title").text(entry.title.$t))
			  .append($("<div/>").addClass("property").addClass("author").text("By: " + entry.author[0].name.$t))
			  .append($("<div/>").addClass("property").addClass("time").text("Duration: " + entry.media$group.media$thumbnail[0].time))
			  .append($("<div/>").addClass("property").addClass("rating").text("Rating: " + (entry.gd$rating ? parseFloat(entry.gd$rating.average).toFixed(1) : "")))
			  .append($("<div/>").addClass("property").addClass("views").text(entry.yt$statistics.viewCount + " Views"))
			  .attr("id", entry.id.$t.split(":video:")[1]);
	
	if(even){$newEntry.addClass("even")}		
	$feedView.append($newEntry)
}

var firstFocus = true;
function onytplayerStateChange(newState){

	
	loopButton.disabled = (newState != 1);
	
	if(newState==1){
		if(firstFocus){
			firstFocus = false;
			loopButton.focus();
		}
		
		setLoopFromURL();
	}
	
									
}

var bar;
var $bar;
var meter;
function resetMeter(){
	pwidth = parseInt(player.getAttribute("width")) -1;
	bar = document.createElement("div");
	bar.id = "bar";
	bar.style.display = "none";
	meter = document.getElementById("meter")
	meter.id="meter";
	meter.appendChild(bar);
	meter.style.width = pwidth - PLAYER_PADDING_RIGHT - PLAYER_PADDING_LEFT -2 + "px";
	meter.style.paddingLeft = PLAYER_PADDING_LEFT + "px";							
	meter.style.paddingRight = PLAYER_PADDING_RIGHT + "px";	
	$bar = $(bar);
	
}

var lastStart
function setStart(start){
	lastStart = start;
	$bar.css({"margin-left": parseInt(widthTimeRatio * start) + "px"})
		.width(1)
		.show();
		
	$startLabel.text(normalizeTime(start))
			   .show();
			
	$startLabel.offset({top: $bar.offset().top, left: $bar.offset().left - 83});
	
	 repositionLabels();
}

var lastEnd;
function setEnd(end, repeat){
	lastEnd = end;
	$bar.width(widthTimeRatio * repeat);
	$endLabel.text(normalizeTime(end))
			 .show();
			
			
	$endLabel.offset({top: $bar.offset().top, left: $bar.offset().left + $bar.width() - 8});
	 repositionLabels();
}


function repositionLabels(){
	$startLabel.offset({top: $bar.offset().top, left: $bar.offset().left - 83});
	$endLabel.offset({top: $bar.offset().top, left: $bar.offset().left + $bar.width() - 8});
}

function load(){
	cancel();
	widthTimeRatio = 0;
	value = document.getElementById("url").value;
	// its a url
	if(value.search("youtube.com") > -1){
		player.loadVideoById(value.split("v=")[1].split("&")[0]);
		newVideo(value.split("v=")[1].split("&")[0]);
	} else {
		player.loadVideoById(value);
		newVideo(value);
	}
}

var lastVideoID;
function newVideo(id){
	lastVideoID = id;
	window.location.hash = id;
	$("#shareURL").val("http://loopthetube.com#" + id);
}

function checkHistoryChanges(){
	if(window.location.hash.replace("#","").split("&")[0] != lastVideoID){
		lastVideoID = window.location.hash.replace("#","").split("&")[0];
		player.loadVideoById(window.location.hash ? window.location.hash.replace("#","") : defaultVideo);
	}
}

function showtip(){
	var tip = document.getElementById("tip")
		tip.style.display = "block";
	
}

var timeLeftMS = 0;
var realTimeToVideoTimeRatio = 0;
var lastTimeWasZero = false;
var lastBarWidth = 0;
function poll(){

	calculateTime2PixelRation();
	
	if(player.getCurrentTime() > endTime + 1 || player.getCurrentTime() < (startTime - 3)){
		
		cancel();
		return;
	}
	
	
	
	if(timeLeftMS <= 0 && lastTimeWasZero){
		lastTimeWasZero = false;
		clearInterval(lastInterval);
		setTimeout(repeat, 1500);
		timeLeftMS = (endTime * 1000) - (player.getCurrentTime() * 1000);
		return;
	}	
	else if(timeLeftMS <= POLLING_INTERVAL){
		lastTimeWasZero = timeLeftMS <= 0;
		clearInterval(lastInterval);
		lastInterval = 0;
		setTimeout(repeat, timeLeftMS);
	} else {
		lastTimeWasZero = timeLeftMS <= 0;
		timeLeftMS = (endTime * 1000) - (player.getCurrentTime() * 1000);
	}
	
}

function normalizeTime(time){
	
	//time +=1;
	var secs = parseInt(time);
	var ms = parseInt((time - secs) * 100);
	var mins = 0;
					
	if(secs >= 60){
		mins = time / 60;
		secs = time % 60;
		
	} 
	mins = parseInt(mins);
	secs = parseInt(secs);
	ms = parseInt(ms);
	
	return  mins + ":" +
	 		(secs<10 ? "0" + secs : secs)  + ":" +
	 		(ms<10 ? "0" + ms : ms) ;
}




function getIdForVideoName(name){
	for(i=0; i < lastFeed.feed.entry.length; i++){
		if (lastFeed.feed.entry[i].title.$t == name){
			return lastFeed.feed.entry[i].id.$t.split(":video:")[1];
		}
	}
}