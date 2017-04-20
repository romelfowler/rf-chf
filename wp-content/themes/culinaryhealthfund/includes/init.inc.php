<?php
date_default_timezone_set('America/New_York');

define('TIME_NOW', time());
define('THIS_SCRIPT', $_SERVER['PHP_SELF']);

define('PATH_BASE', $_SERVER['DOC_ROOT_CHF'] . '/');
define('PATH_INCLUDE', $_SERVER['DOC_ROOT_CHF'] . '/wp-content/themes/culinaryhealthfund/includes/');
define('PATH_CLASS', PATH_INCLUDE . 'classes/');

define('BASE_URL', '/');

if ($_SERVER['PHP_ENV'] == "staging") {
	define('SITE_URL', 'http://www.staging.culinaryhealthfund.org');
} else {
	define('SITE_URL', 'http://www.culinaryhealthfund.org');
}


/** MySQL hostname */


$CONF = array(
	  'db.chf' => array(
		'dbms'     => 'mysqli',
		'host'     => $_SERVER['DB_HOST'],
		'port'	   => 3306,
		'username' => $_SERVER['DB_USER'],
		'password' => $_SERVER['DB_PASSWORD'],
		'database' => $_SERVER['DB_NAME']
	  )
	);

$urlPiece = explode(".", $_SERVER['HTTP_HOST']);
$currentLanguage = $urlPiece[0];





include_once (PATH_CLASS . 'Database.class.php');
$db	= Database::factory($CONF['db.chf']);

include_once (PATH_CLASS . 'Pagination.class.php');

include_once (PATH_INCLUDE . 'functions.inc.php');

include_once (PATH_CLASS . 'Provider.class.php');
$provider = new Provider();

include_once (PATH_CLASS . 'Contact.class.php');
$contact = new Contact();
?>