<?php 

session_start();

$string = 'rm /var/www/Giftest/*.gif';
exec($string);

if(($_POST['B']) = True){
	echo "o";	
}


?>