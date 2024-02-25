<?php
	session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.

    // include - site details
    include($path."assets/includes/site_details.php");

	// include - connection
	include ($path."assets/includes/connection.php");	 

	$username = $_POST["username"];
	$password = $_POST["password"];

	//Create query
	$query =  "SELECT *
				FROM treedata_users
				WHERE username='$username' 
				AND  password='$password'";

	$result = mysqli_query ($connection, $query);

	$queryAdmin =  "SELECT *
					FROM treedata_users
					WHERE username='$username' 
					AND password='$password'
					AND isAdmin=1";

	$resultAdmin = mysqli_query ($connection, $queryAdmin);


	//if rows found set authenticated user to the username entered 
	if (mysqli_num_rows($result) > 0)
	{ 
		$_SESSION["authenticated_user"] = $username;
		header('Location: '.$path.'pages/login/user_logged_on.php');

		if(mysqli_num_rows($resultAdmin) > 0)
		{
			$_SESSION["isAdmin"] = "true";
		}
	} 
	
	//login failed redirect back to login page with error message
	else
	{
		$_SESSION["message"] = "login in error" ;
		header('Location: '.$path);
	}
?>
