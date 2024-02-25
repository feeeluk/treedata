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
	$siteShortcode=$_GET['siteShortcode'];
	$siteName=$_GET['siteName'];
	$siteNameUpdated=$_GET['txt_siteName'];
	$siteDescription=$_GET['txt_siteDescription'];
	$siteContactName=$_GET['txt_siteContactName'];
	$siteContactTelephone=$_GET['txt_siteContactTelephone'];
	$siteAddress1=$_GET['txt_siteAddressLine1'];
	$siteAddress2=$_GET['txt_siteAddressLine2'];
	$siteCity=$_GET['txt_siteCity'];
	$sitePostcode=$_GET['txt_sitePostcode'];
	$treeID=$_GET['treeID'];
	$treeName=$_GET['txt_treeName'];
	$treeDescription=$_GET['txt_treeDescription'];
	$treeSpecies=$_GET['select_treeSpecies'];
	$treeVitality=$_GET['select_treeVitality'];
	$treeAgeClass=$_GET['select_treeAgeClass'];
	$treeLatitude=$_GET['txt_treeLatitude'];
	$treeLongitude=$_GET['txt_treeLongitude'];
	$treeHeight=$_GET['txt_treeHeight'];
	$treeCrownSpread=$_GET['txt_treeCrownSpread'];
	$treeStemDiameter=$_GET['txt_treeStemDiameter'];
		

	// ################################################################################
	// siteDelete
	if (isset($_GET['siteDelete']))
	{
		// build query
		$querySiteDelete = "DELETE FROM treedata_sites WHERE shortcode = '$siteShortcode'"; 

		// Execute query
		$resultSiteDelete = mysqli_query($connection, $querySiteDelete);

		// set the message to display to the user
		$_SESSION["message"] = "site deleted";

		// redirect the location
		header("Location: ".$path."pages/admin/admin_site_all.php");
	}

	// ################################################################################
	// siteEdit
	elseif (isset($_GET['siteEdit']))
	{	    
		// build query
		$querySiteEdit = "UPDATE treedata_sites SET ". 
								"name='$siteNameUpdated',".
								"description='$siteDescription',".
								"address_line_1='$siteAddress1',".
								"address_line_2='$siteAddress2',".
								"city='$siteCity',".
								"postcode='$sitePostcode',".
								"contact_name='$siteContactName',".
								"contact_telephone='$siteContactTelephone'". //remember to remove the comma at the end of the final line
								"WHERE shortcode = '$siteShortcode'"; 

		//Execute query
		$resultSiteDescription = mysqli_query($connection, $querySiteEdit);

		// set the message to display to the user
		$_SESSION["message"] = "site details updated";
		
		// redirect the location
		header("Location: ".$path."pages/admin/admin_site_view.php?siteShortcode=".$siteShortcode."&siteName=".$siteNameUpdated);
	}

	// ################################################################################
	// siteEditCancel
	elseif (isset($_GET['siteEditCancel']))
	{	    
		// set the message to display to the user
		$_SESSION["message"] = "action cancelled";
		
		// redirect the location
		header("Location: ".$path."pages/admin/admin_site_all.php");
	}

	// ################################################################################	
	// siteTreesEdit
	if (isset($_GET['siteTreesEdit']))
	{
		// build query
		$queryTreesEdit = 	"UPDATE treedata_site_trees SET ". 
							"name='$treeName',".
							"description='$treeDescription',".
							"species='$treeSpecies',".
							"vitality='$treeVitality',".
							"latitude='$treeLatitude',".
							"longitude='$treeLongitude',".
							"height='$treeHeight',".
							"age_class='$treeAgeClass',".
							"crown_spread='$treeCrownSpread',".
							"stem_diameter='$treeStemDiameter'". //remember to remove the comma at the end of the final line
							"WHERE shortcode = '$siteShortcode' AND tree_id = '$treeID'"; 

		//Execute query
		$resultTreesEdit = mysqli_query($connection, $queryTreesEdit);

		// set the message to display to the user
		$_SESSION["message"] = "tree details updated";

		// redirect the location
		header("Location: ".$path."pages/admin/admin_site_view.php?siteShortcode=".$siteShortcode."&siteName=".$siteName);
	}

	// ################################################################################
	// siteTreesCancel
	elseif (isset($_GET['siteTreesCancel']))
	{

		// set the message to display to the user
		$_SESSION["message"] = "action cancelled";

		// redirect the location
		header("Location: ".$path."pages/admin/admin_site_view.php?siteShortcode=".$siteShortcode."&siteName=".$siteName);
	}

	// ################################################################################
	// siteTreesDelete
	elseif (isset($_GET['siteTreesDelete']))
	{
		$queryTreesDelete = "DELETE FROM treedata_site_trees WHERE shortcode = '$siteShortcode' AND tree_id = '$treeID'"; 

		// Execute query
		$resultTreesDelete = mysqli_query($connection, $queryTreesDelete);

		// set the message to display to the user
		$_SESSION["message"] = "tree deleted";

		// redirect the location
		header("Location: ".$path."pages/admin/admin_site_view.php?siteShortcode=".$siteShortcode."&siteName=".$siteName);
	}

?>