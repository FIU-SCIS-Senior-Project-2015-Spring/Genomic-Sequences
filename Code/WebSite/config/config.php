<?php

/*
*	Configuration details are stored here. For now, only CONSTANTS and PATHS are within this file!
*/

define('DB_HOST', 'localhost');
define('DB_USER', 'postgres');
define('DB_PASS', 'genomepro2015');
define('DB_NAME', 'genomepro2');

define('SITE_TITLE', 'GenomePro');
define('DEFAULT_AVATAR', 'default.jpg');

define('USR_INV', 0);
define('USR_REG', 1);
define('USR_ADMIN', 2);

define('JOB_PEND', 1);
define('JOB_DONE', 2);

define('TYPE_UNK', 1);
define('TYPE_INV', 2);
define('TYPE_DNA', 3);
define('TYPE_RNA', 4);
define('TYPE_PROTEIN', 5);
define('TYPE_MAPS', 6);
define('TYPE_EXT', 7);
define('TYPE_SORTED', 8);

define('TOOL_GENSIG', 1);
define('TOOL_REPSEQ', 2);
define('TOOL_GENPROBS', 3);
define('TOOL_UNIQSEQ', 4);
define('TOOL_EXTFAST', 5);
define('TOOL_SORTSEQ', 6);
define('TOOL_VALIDATE', 7);
define('TOOL_MAPS', 8);

define('STEPS_EXT2SORT', 2);
define('STEPS_EXT2MAPS', 3);

define('KIND_SINGLE', 1);
define('KIND_MULTIPLE', 2);

/*
*	FOLDERS: All URLs to folders are here, in case they're changed later.
*/

define('BASE_DIR', 'http://genomepro.cis.fiu.edu/');
define('SERVER_DIR', '/var/www/html/');
define('CONFIG_DIR', 'config/');
define('CORE_DIR', 'core/');
define('HELPERS_DIR', 'helpers/');
define('LIBRARIES_DIR', 'libraries/');
define('TEMPLATES_DIR', 'templates/');
define('FILES_DIR', 'delivery/');
define('AVATAR_DIR', 'avatars/');
define('UPLOADS_DIR', 'uploads/');
define('RESULTS_DIR', 'results/');
define('PROGRAMS_DIR', 'programs/');

/*
*	ITEMS: All template file names are stored here, in case they're changed later.
*/

define('INDEX', 'index.php');
define('ABOUT', 'about.php');
define('CONTACT', 'contact.php');
define('TOOLS', 'tools.php');
define('HISTORY', 'history.php');
define('REGISTER', 'register.php');
define('PROFILE', 'profile.php');
define('CHARTS', 'charts.php');
define('FTP', 'ftp.php');

define('BATCH_NAME', 'batch.txt');
define('RESULTS_NAME', 'results.txt');

/*
*	Mailer settings and stuff!
*/

define('EMAIL_USERNAME', 'genomeprofiu');
define('EMAIL_PASSWORD', 'genomeprofall2015');
define('EMAIL_WHEN_RECEIVING', 'michael.robinson@cs.fiu.edu');
define('EMAIL_WHEN_SENDING', 'genomeprofiu@gmail.com');
define('EMAIL_NAME', 'GenomePro Team');
define('EMAIL_CONTACT_SUBJECT', '[From Website] New User Message');