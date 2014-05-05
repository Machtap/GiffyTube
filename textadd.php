<?php

session_start();
$TT = sanitize($_POST['TT']);
$BT = sanitize($_POST['BT']);
$G = sanitize($_POST['UID']);
$T = time();
$UID = substr($G, 0, 11);

function sanitize($string) {

  if (ctype_alnum($string)) {
    return $string;
  }
  // $pattern = "/(A-Za-z0-9]+/";
  // if(preg_match($pattern, $string)) {
  //   return $string;
  // }
  else {
    return "=";
  }
}
$mkdir = "touch output/gifimages/".$G."/".$UID.".gif";
$commandString1 = "convert -loop 0 -limit -pointsize 35 -fill white -stroke black -weight bold -gravity North -draw 'text 0,10 \"". $TT ."\" ' output/gifimages/".$G."/".$G."*.gif output/gifimages/".$G."/".$UID.".gif";
$commandString2 = "convert -pointsize 35 -fill white -stroke black -weight bold -gravity South -draw 'text 0,10 \"". $BT ."\" ' output/gifimages/".$G."/".$UID.".gif output/gifimages/".$G."/".$UID.".gif";
exec($mkdir);
exec($commandString1);
exec($commandString2);
echo $G;
//echo $commandString1;

?>