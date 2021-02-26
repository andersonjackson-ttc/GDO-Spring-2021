<?php 

// This file contains the database access information.
// This file also establishes a connection to MySQL,
// selects the database, and sets the encoding.

	#author: Dustin Brown - dustin.a.brown@protonmail.com


// Set the database access information as constants:
DEFINE ('DB_USER', 'gdoadmin');  //replace *s with database username
DEFINE ('DB_PASSWORD', 'nwicTtc42!'); //replace *s with database password
DEFINE ('DB_HOST', '192.168.6.3'); //replace *s with hostnameor ip address of database server
DEFINE ('DB_NAME', 'admin_login'); //current name of database

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');
?>
