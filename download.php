<?php 
session_start();

$UID = getYoutubeId($_POST['UID']);

function getYoutubeId($youtube) {
    $url = parse_url($youtube);
    if(
         $url['host'] !== 'youtube.com' &&
         $url['host'] !== 'www.youtube.com'&&
         $url['host'] !== 'youtu.be'&&
         $url['host'] !== 'www.youtu.be')
        {return false;}
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
//$download = "youtube-dl -f 18 -o \"tmp/\"" . $UID . ".mp4\" " . $UID;
$download = "youtube-dl -f 18 " . $UID . " -o" . $UID . ".mp4";

$download_escaped = escapeshellcmd($download);

exec($download_escaped);
?>