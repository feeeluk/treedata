<?php

	// set server access variables 
	$hostname = "db5015115557.hosting-data.io"; 
	$username = "dbu5478137"; 
	$password = "database@treedata"; 
	$databaseName = "dbs12534339";

	// open connection 
	$connection = mysqli_connect($hostname, $username, $password, $databaseName );
	
	// select database 
	//mysqli_select_db($databaseName); 
?>