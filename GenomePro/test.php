<?php
$host = "127.0.0.1";
$user = "postgres";
$pass = "1234";
$db = "genomepro";

$con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");
	
$query = "SELECT VERSION()";
$rs = pg_query($con,$query) or die ("Cannot execute query: $query\n");
$row = pg_fetch_row($rs);

echo $row[0] . "\n";

pg_close($con);
?>
