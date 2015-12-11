<?php
/* DB_CLEANER.PHP **************************************************
*   File: 			db_cleaner.php
*	Author: 		Guido Ruiz, Mordecai Mesquita
*	Updated: 		12/02/2015
*
*	Purpose:		The Grim Reaper of the database. For now, all 
*                   it does is delete inactive users as well as bad
*                   files from the database every day. We don't do
*                   this right away for logging purposes.
*
*	Requirements:   config.php must exist, as this script requires a
*					lot of different global definitions. It is done
*					this way in case the structure of the database
*					changes or if something major changes, that way
*					changing only the global variable will do the
*					trick for this file and many others.
*/

require '/var/www/html/config/config.php'; // super important!!

$conn = pg_connect("host=" . DB_HOST . " dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASS) or die('connection failed');

$q = "DELETE FROM website.users
	  WHERE type = " . USR_INV . " 
      RETURNING user_id, username";

$users = pg_query($conn, $q);
if(!$users) { echo "error executing query"; die(); }

while($row = pg_fetch_row($users)) echo "User: $row[0], '" . trim($row[1]) . "', was deleted.\n";

$q = "DELETE FROM website.files
	  WHERE type_id = " . TYPE_INV . "
      RETURNING file_id, name, path";

$files = pg_query($conn, $q);
if(!$files) { echo "error executing query"; die(); }

while($row = pg_fetch_row($files)) echo "File: $row[0], '" . trim($row[2]) . trim($row[1]) . "', was deleted.\n";
?>