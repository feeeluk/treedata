<?php

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.

    // include - site details
    include($path."assets/includes/site_details.php");

	include ($path."assets/includes/connection.php");

	session_start();
	$username=$_GET['username'];
	$f_name=$_GET['txt_f_name'];
	$l_name=$_GET['txt_l_name'];
	$address_line_1=$_GET['txt_address_line_1'];
	$address_line_2=$_GET['txt_address_line_2'];
	$city=$_GET['txt_city'];
	$postcode=$_GET['txt_postcode'];
	$mobile=$_GET['txt_mobile'];

	// ################################################################################
	// delete pressed
	if (isset($_GET['deleteUser']))
	{
		// build query
		$queryDelete = "DELETE FROM treedata_users WHERE username = '$username'"; 
		
		// execute query
		$result = mysqli_query($connection, $queryDelete);

		// set the message to display to the user
		$_SESSION["message"] = "user deleted";

		// redirect the location
		header("Location: ".$path."pages/admin/admin_users_all.php");
	}

	// ################################################################################
	// edit pressed
	if (isset($_GET['editUser']))
	{
		// build query
		$queryEdit = "UPDATE treedata_users SET ". 
		"f_name='$f_name',".
		"l_name='$l_name',".
		"address_line_1='$address_line_1',".
		"address_line_2='$address_line_2',".
		"city='$city',".
		"postcode='$postcode',".
		"mobile='$mobile'". //remember to remove the comma at the end of the final line
		"WHERE username = '$username'"; 

		// execute query
		$result = mysqli_query($connection, $queryEdit);

		// set the message to display to the user
		$_SESSION["message"] = "user details updated";

		// redirect the location
		header("Location: ".$path."pages/admin/admin_users_all.php");	
	}

	// ################################################################################
	// cancel pressed
	elseif (isset($_GET['cancel']))
	{
		// set the message to display to the user
		$_SESSION["message"] = "update cancelled";

		// redirect the location
		header("Location: ".$path."pages/admin/admin_users_all.php");	
	}
?>