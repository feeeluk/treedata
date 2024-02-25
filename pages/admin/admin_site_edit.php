<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Edit Site:";

    // include - site details
    include($path."assets/includes/site_details.php"); 

	// include - connection
	include ($path."assets/includes/connection.php");

	// Check if we have an authenticated user & admin
	//if not re-direct to login page
	if (!isset($_SESSION["authenticated_user"]) && !isset($_SESSION["isAdmin"]))
	{
		$_SESSION["message"] = "please log in";
		header("Location: $path");
	}
	
	else
	{ 
		//If authenticated then display page contents

		// include - header
		include($path."assets/includes/header.php");

		// include - login
		include($path."assets/includes/login.php");

		// set variables
		$siteShortcode = $_GET["siteShortcode"];
		$siteName = $_GET["siteName"];

	?>    
			<div id="text">
                				
                <h2><?php echo $subTitle; ?> <?php echo $siteName; ?></h2>
		
                <p>
                
                <?php

					$query = "	SELECT DISTINCT *
									FROM treedata_sites
									WHERE treedata_sites.shortcode='$siteShortcode'";
            		$result = mysqli_query ($connection, $query);
			
            		//Check to see you have got at least 1 record 
            		if (mysqli_num_rows($result) > 0) 
            		{
            			$row = mysqli_fetch_array($result);

            			echo "<form class='treeEdit' method='GET' action='".$path."pages/admin/admin_site_action.php'>";
            			echo "<input type='hidden' name='siteName' id='' value='".$siteName."' />";
            			echo "<input type='hidden' name='siteShortcode' id='' value='".$siteShortcode."' />";
            			
            			echo "<table class='siteEdit'>";
            			
	            			echo "<tr>";
	            			echo 	"<td>Name:</td>";
	            			echo 	"<td><input type='text' name='txt_siteName' id='' value='".$siteName."' /></td>";
	            			echo 	"<td rowspan='10'><img width='200' src='".$path."assets/images/site/".$siteShortcode."/".$row['image']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Shortcode:</td>";
	            			echo 	"<td>".$siteShortcode."</td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Description:</td>";
	            			echo 	"<td><input type='text' name='txt_siteDescription' id='' value='".$row['description']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Address 1:</td>";
	            			echo 	"<td><input type='text' name='txt_siteAddressLine1' id='' value='".$row['address_line_1']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Address 2:</td>";
	            			echo 	"<td><input type='text' name='txt_siteAddressLine2' id='' value='".$row['address_line_2']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>City:</td>";
	            			echo 	"<td><input type='text' name='txt_siteCity' id='' value='".$row['city']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Postcode:</td>";
	            			echo 	"<td><input type='text' name='txt_sitePostcode' id='' value='".$row['postcode']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Contact:</td>";
	            			echo 	"<td><input type='text' name='txt_siteContactName' id='' value='".$row['contact_name']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Telephone:</td>";
	            			echo 	"<td><input type='text' name='txt_siteContactTelephone' id='' value='".$row['contact_telephone']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td></td>";
	            			echo 	"<td>";
	            			echo 		"<input type='submit' name='siteEdit' value='Edit' />&nbsp;";
	            			echo 		"<input type='submit' name='siteEditCancel' value='Cancel' />";
	            			echo 	"</td>";
	            			echo 	"<td></td>";
	            			echo "</tr>";

	            		echo "</table>";
	            		echo "</form>";
	            		
					}
                
	                else               
	                {
	                	echo "<p>No details found <p>";
	                }
                
					// Close the DBMS connection 
        			mysqli_close($connection);	                

    			?>

    			</p>
                
			</div>
			
		</div>
		
	</body>

</html>

<?php

	}

?>
