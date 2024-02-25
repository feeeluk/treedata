<?php
	session_start();


    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.

	// include - site details
	Include($path."assets/includes/site_details.php"); 

	unset($_SESSION['authenticated_user']);
	unset($_SESSION['authenticated_admin']);
	unset($_SESSION['isAdmin']);

	// Relocate back to the login page
	header('Location: '.$site);

	$_SESSION["message"] = "user logged out";
?> 
