<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Sites";

    // include - site details
    include($path."assets/includes/site_details.php"); 

	// include - connection
	include ($path."assets/includes/connection.php");

	// Check if we have an authenticated user
	//if not re-direct to login page
	if (!isset($_SESSION["authenticated_user"]))
	{
		$_SESSION["message"] = "please log in";
		header("Location: ".$path);
	}
	
	else
	{ 
		//If authenticated then display page contents

		$username = $_SESSION["authenticated_user"];
		$siteShortcode = $_GET["siteShortcode"];
		$siteName = $_GET["siteName"];

		// include - header
		include($path."assets/includes/header.php");

		// include - login
		include($path."assets/includes/login.php");

	?>
          
			<div id="text">
                				
                <h2><?php echo $subTitle; ?></h2>
		
                <p>

                	<?php

					$query = "	SELECT treedata_sites.name, treedata_sites.shortcode
								FROM treedata_user_sites
								JOIN treedata_sites ON treedata_user_sites.site_shortcode=treedata_sites.shortcode
								WHERE treedata_user_sites.username='$username'";
	        		$result = mysqli_query ($connection, $query);
			
            		//Check to see you have got at least 1 record 
            		if (mysqli_num_rows($result) > 0) 
            		{
            				echo "<table class='sitesAll'>";
	            			echo "<tr>";
	            			echo "<th>Name</th>";
	            			echo "<th>Shortcode</th>";
	            			echo "</tr>";

            			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	            		{
	            			echo "<form action='".$path."pages/login/user_logged_on_site_details.php' method='GET' name='form_viewSite' id='form_viewSite'>";
	            			echo "<input type='hidden' id='siteShortcode' name='siteShortcode' value='".$row['shortcode']."'>";
	            			echo "<input type='hidden' id='siteName' name='siteName' value='".$row['name']."'>";
	            			
	            			
	            			echo "<tr>";
	            			echo "<td>".$row['name']."</td>";
	            			echo "<td>".$row['shortcode']."</td>";
	            			echo "<td><input name='viewSite' type='submit' value='View' /></td>";
	            			echo "</tr>";
	            			echo "</form>";
	            		}

	            		echo "</table>";
					}
                
	                else               
	                {
	                	echo "<p>No sites linked to your account <p>";
	                }
                
            	?>
    			</p>
                
			</div>
			
		</div>
		
	</body>

</html>

<?php

	}

?>
