<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Site:";

    // include - site details
    include($path."assets/includes/site_details.php"); 

	// include - connection
	include ($path."assets/includes/connection.php");

	// Check if we have an authenticated user
	//if not re-direct to login page
	if (!isset($_SESSION["authenticated_user"]))
	{
		$_SESSION["message"] = "please log in";
		header("Location:".$path);
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
                				
                <h2><?php echo $subTitle; ?> <?php echo $siteName; ?></h2>
		
                <p>
                               <?php

					$querySite = "	SELECT DISTINCT *
									FROM treedata_user_sites
									JOIN treedata_sites ON treedata_user_sites.site_shortcode=treedata_sites.shortcode
									WHERE treedata_sites.shortcode='$siteShortcode'";
            		$resultSite = mysqli_query ($connection, $querySite);
			
            		//Check to see you have got at least 1 record 
            		if (mysqli_num_rows($resultSite) > 0) 
            		{
            			$row = mysqli_fetch_array($resultSite);
            			
            			echo "<form name='' id='siteFullDetails' method='GET' action='".$path."pages/login/user_logged_on_site_full_details.php'>";
            			echo "<input type='hidden' name='siteShortcode' id='siteShortcode' value='".$siteShortcode."' />";
            			echo "<input type='hidden' name='siteName' id='siteName' value='".$siteName."' />";
            			


            			echo "<table class='siteDetailsSite'>";
            			
	            			echo "<tr>";
	            			echo 	"<td>Name:</td>";
	            			echo 	"<td>".$siteName."</td>";
	            			echo 	"<td rowspan='7'><img width='200' src='".$path."assets/images/site/".$siteShortcode."/".$row['image']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Shortcode:</td>";
	            			echo 	"<td>".$siteShortcode."</td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Contact:</td>";
	            			echo 	"<td>".$row['contact_name']."</td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Telephone:</td>";
	            			echo 	"<td>".$row['contact_telephone']."</td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>City:</td>";
	            			echo 	"<td>".$row['city']."</td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Postcode:</td>";
	            			echo 	"<td>".$row['postcode']."</td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td></td>";
	            			echo 	"<td><button type='submit' formid='siteFullDetails'>See all details</button></td>";
	            			echo "</tr>";

	            		echo "</table>";

	            		echo "</form>";
	          						
					}
                
	                else               
	                {
	                	echo "No rows found"; 
				
						// Close the DBMS connection 
						mysqli_close($connection);
	                }
                
            	?>
                </p>
                
                <h3>The trees at this site are:</h3>
                <p>

                	<?php

					$queryTrees = "	SELECT LPAD(treedata_site_trees.tree_id, 5, '0') AS tree_id, treedata_tree_vitality.name AS vitality, treedata_tree_species.name AS species
							FROM treedata_site_trees
							JOIN treedata_tree_species ON treedata_site_trees.species=treedata_tree_species.id
							JOIN treedata_tree_vitality ON treedata_site_trees.vitality=treedata_tree_vitality.id
							WHERE treedata_site_trees.shortcode='$siteShortcode'
							ORDER BY tree_id ASC";
            		$resultTrees = mysqli_query ($connection, $queryTrees);
			
            		//Check to see you have got at least 1 record 
            		if (mysqli_num_rows($resultTrees) > 0) 
            		{
            				echo "<table class='siteDetailsTrees'>";
	            			echo "<tr>";
	            			echo "<th>Tree ID</th>";
	            			echo "<th>Species</th>";
	            			echo "<th>Viatality</th>";
	            			echo "<th></th>";
	            			echo "</tr>";

            			while($row = mysqli_fetch_array($resultTrees, MYSQLI_ASSOC))
	            		{
							echo "<form name='viewSiteTree' id='viewSiteTree' action='".$path."pages/login/user_logged_on_site_tree_details.php' method='GET'>";
							echo "<input type='hidden' name='siteShortcode' id='siteShortcode' value='".$siteShortcode."' />";
							echo "<input type='hidden' name='siteName' id='siteName' value='".$siteName."' />";
							echo "<input type='hidden' name='siteTreeID' id='siteTreeID' value='".$row['tree_id']."' />";

							echo "<tr>";
	            			echo 	"<td>".$row['tree_id']."</td>";
	            			echo 	"<td>".$row['species']."</td>";
	            			echo 	"<td>".$row['vitality']."</td>";
	            			echo 	"<td><input type='submit' name='viewButton' value='View' /></td>";
	            			echo "</tr>";
	            			echo "</form>";
	            		}

	            		echo "</table>";
					}
                
	                else               
	                {
	                	echo "<p>No details found <p>";
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
