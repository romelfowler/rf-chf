<?php
/** MySQL hostname */
$CONF = array(
	  'db.chf' => array(
		'dbms'     => 'mysqli',
		'host'     => $_SERVER['DB_HOST'],
		'port'	   => 3306,
		'username' => $_SERVER['DB_USER'],
		'password' => $_SERVER['DB_PASS'],
		'database' => $_SERVER['DB_NAME']
	  )
	);

#define('FREE_MEDIA_CREDITS', 250);

?>