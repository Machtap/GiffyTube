<?php

session_start();
$S = getStartTime($_POST['S']);
$D = getDuration($_POST['D']);
$UID = getYoutubeId($_POST['UID']);
$T = time();

function getYoutubeId($youtube) {
    $url = parse_url($youtube);
    if(    
        $url['host'] !== 'youtube.com' &&
        $url['host'] !== 'www.youtube.com'&&
        $url['host'] !== 'youtu.be'&&
        $url['host'] !== 'www.youtu.be'
      ){return false;}
    $youtube = preg_replace('~
        # Match non-linked youtube URL in the wild. (Rev:20111012)
        https?://         # Required scheme. Either http or https.
        (?:[0-9A-Z-]+\.)? # Optional subdomain.
        (?:               # Group host alternatives.
          youtu\.be/      # Either youtu.be,
        | youtube\.com    # or youtube.com followed by
          \S*             # Allow anything up to VIDEO_ID,
          [^\w\-\s]       # but char before ID is non-ID char.
        )                 # End host alternatives.
        ([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
        (?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
        (?!               # Assert URL is not pre-linked.
          [?=&+%\w]*      # Allow URL (query) remainder.
          (?:             # Group pre-linked alternatives.
            [\'"][^<>]*>  # Either inside a start tag,
          | </a>          # or inside <a> element text contents.
          )               # End recognized pre-linked alts.
        )                 # End negative lookahead assertion.
        [?=&+%\w]*        # Consume any URL (query) remainder.
        ~ix', 
        '$1',
        $youtube);
    $youtube = substr($youtube, 0, 11);
    return $youtube;
}

function getStartTime($Start) {

  $pattern = "/^([0-5]?[0-9]):([0-5]?[0-9])$/";
  if (preg_match($pattern, $Start)) {
    $secondpattern = "/^([0-5][0-9]):([0-5]?[0-9])$/";
    if (preg_match($secondpattern, $Start)) {
      return $Start;
    }
    else {
      $Start = "0" . $Start;
      return $Start;
    }
  }
  else {
    return "error!";
  }
}

function getDuration($dur) {

  $pattern = "/^[0-5]?[0-9]$/";
  if (preg_match($pattern, $dur)) {
    return $dur;
  }
  else {
    return "error!";
  }
}

$G = $UID . $T;

$folderString = "mkdir output/gifimages/" . $G ;
$firstString = "ffmpeg -i " . $UID . ".mp4 -r 13 output/gifimages/". $G . "/" . $G . "%03d.gif -ss 00:" . $S . " -t " . $D;
$thirdString = "gifsicle --delay=8 --loop output/gifimages/". $G . "/" . $G . "*.gif > output/" . $G . ".gif ";
$finalstring2 = "rm " . $UID . ".mp4";
exec($folderString);

exec($firstString);

exec($thirdString);

exec($finalstring2);

?>