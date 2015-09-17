<?php

/*
*	Configuration details are stored here. For now, only CONSTANTS and PATHS are within this file!
*/

define('DB_HOST', 'localhost');
define('DB_USER', 'postgres');
define('DB_PASS', 'genomepro2015');
define('DB_NAME', 'genomepro2');
define('SITE_TITLE', 'GenomePro');

/*
*	FOLDERS: All URLs to folders are here, in case they're changed later.
*/

define ('BASE_DIR', 'http://'.$_SERVER['SERVER_NAME'].'/');
define ('CONFIG_DIR', 'config/');
define ('CORE_DIR', 'core/');
define ('HELPERS_DIR', 'helpers/');
define ('LIBRARIES_DIR', 'libraries/');
define ('TEMPLATES_DIR', 'templates/');
define('FILES_DIR', 'uploads/');

/*
*	ITEMS: All template file names are stored here, in case they're changed later.
*/

define ('INDEX', 'index.php');
define ('ABOUT', 'about.php');
define ('CONTACT', 'contact.php');
define ('TOOLS', 'tools.php');
define ('HISTORY', 'history.php');
define ('REGISTER', 'register.php');

/*
*	Mailer settings and stuff!
*/

define('EMAIL_WHEN_RECEIVING', 'genomeprofiu@gmail.com');
define('EMAIL_WHEN_SENDING', 'genomepro@donotreply.com');
define('EMAIL_NAME', 'GenomePro Team');

define('EMAIL_CONTACT_SUBJECT', '[From Website] New User Message');

define('EMAIL_USERNAME', 'genomeprofiu');
define('EMAIL_PASSWORD', 'genomeprofall2015');