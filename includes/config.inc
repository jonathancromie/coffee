<?php
	$dbhost = '127.0.0.1:3306';
	$dbuser = 'root';
	$dbpass = 'password';
	
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);

	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('coffee');
?>
