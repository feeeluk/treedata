<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Site Details:";

    // include - site details
    include($path."assets/includes/site_details.php"); 

	// include - connection
	include ($path."assets/includes/connection.php");

	// Check if we have an authenticated user
	//if not re-direct to login page
	if (!isset($_SESSION["authenticated_user"]))
	{
		$_SESSION["message"] = "please log in";
		header("Location: $site");
	}
	
	else
	{ 
		//If authenticated then display page contents

		$username = $_SESSION['authenticated_user'];
		$siteShortcode = $_GET['siteShortcode'];
		$siteName = $_GET['siteName'];

		// include - header
		include($path."assets/includes/header.php");

		// include - login
		include($path."assets/includes/login.php");

	?>
          
			<div id="text">
                				
                <h2><?php echo $subTitle; ?> <?php echo $siteName; ?></h2>
                <p>
		
	             <?php

					$query = "	SELECT *
								FROM treedata_sites
								WHERE treedata_sites.shortcode='$siteShortcode'";
            		$result = mysqli_query ($connection, $query);
			
            		//Check to see you have got at least 1 record 
            		if (mysqli_num_rows($result) > 0) 
            		{
            			$row = mysqli_fetch_array($result);

            			echo "<form name='' id='siteDetails' method='GET' action='".$path."pages/login/user_logged_on_site_details.php'>";
            			echo "<input type='hidden' name='siteShortcode' id='siteShortcode' value='".$siteShortcode."' />";
            			echo "<input type='hidden' name='siteName' id='siteName' value='".$siteName."' />";

            			echo "<table class='siteDetailsSite'>";
	            			
	            			echo "<tr><td>Name:</td><td>".$row['name']."</td><td rowspan='10'><img width='200' src='".$path."assets/images/sites/".$siteShortcode."/".$row['image']."' /></td></tr>";
	            			echo "<tr><td>Shortcode:</td><td>".$row['shortcode']."</td></tr>";
	            			echo "<tr><td>Description:</td><td>".$row['description']."</td></tr>";     			
	            			echo "<tr><td>Contact:</td><td>".$row['contact_name']."</td></tr>";
	            			echo "<tr><td>Telephone:</td><td>".$row['contact_telephone']."</td></tr>";
	            			echo "<tr><td>Address 1:</td><td>".$row['address_line_1']."</td></tr>";
	            			echo "<tr><td>Address 2:</td><td>".$row['address_line_2']."</td></tr>";
	            			echo "<tr><td>City:</td><td>".$row['city']."</td></tr>";
	            			echo "<tr><td>Postcode:</td><td>".$row['postcode']."</td></tr>";

	            			echo "<tr>";
	            			echo 	"<td></td>";
	            			echo 	"<td><button type='submit' formid='Details'>Back</button></td>";
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
