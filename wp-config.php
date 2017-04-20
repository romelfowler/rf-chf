<?php

include($_SERVER['DOC_ROOT_CHF'] .'/wp-content/themes/culinaryhealthfund/includes/init.inc.php');
define('DB_NAME', $_SERVER['DB_NAME']);
define('DB_USER', $_SERVER['DB_USER']);
define('DB_HOST', $_SERVER['DB_HOST']);	
define('DB_PASSWORD', $_SERVER['DB_PASSWORD']);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

$table_prefix  = 'chf_';

define('WPLANG', '');
define('WP_DEBUG', true); // Turn debugging ON
define('WP_DEBUG_DISPLAY',false); // Turn forced display OFF
define('WP_DEBUG_LOG', false); // Turn logging to wp-content/debug.log ON

define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);

if ($_SERVER['PHP_ENV'] == 'production') {
	define('DOMAIN_CURRENT_SITE', 'www.culinaryhealthfund.org');
} else {
	define('DOMAIN_CURRENT_SITE', 'www.culinaryhealthfund.org');
}

define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') ) {
	define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
?>