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

					$querySite = "	SELECT DISTINCT *
									FROM treedata_user_sites
									JOIN treedata_sites ON treedata_user_sites.site_shortcode=treedata_sites.shortcode
									WHERE treedata_sites.shortcode='$siteShortcode'";
            		$resultSite = mysqli_query ($connection, $querySite);
			
            		//Check to see you have got at least 1 record 
            		if (mysqli_num_rows($resultSite) > 0) 
            		{
            			$row = mysqli_fetch_array($resultSite);

            			echo "<form id='siteEdit' method='GET' action='".$path."pages/admin/admin_sites_edit.php'>";
            			echo "<input type='hidden' name='siteName' id='' value='".$siteName."' />";
            			echo "<input type='hidden' name='siteShortcode' id='' value='".$siteShortcode."' />";
            			
            			echo "<table class='siteDetailsSite'>";
            			
	            			echo "<tr>";
	            			echo 	"<td>Site Name:</td>";
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
							
							echo "</form>";

							echo "<form id='siteEditCancel' method='GET' action='".$path."pages/admin/admin_site_action.php'>";
							echo "<input type='hidden' name='siteEditCancel' id='' value='1' />";
							echo "</form>";


	            			
	            			echo "<tr>";
	            			echo 	"<td></td>";
	            			echo 	"<td>";
	            			echo 			"<a href='javascript:{}' onclick=\"document.getElementById('siteEdit".$row['treeID']."').submit(); return false;\"><button>Edit</button></a>";
            				echo 			"&nbsp;";
            				echo 			"<a href='javascript:{}' onclick=\"document.getElementById('siteEditCancel".$row['treeID']."').submit(); return false;\"><button>Cancel</button></a>";
	            			echo 	"</td>";
	            			echo 	"<td></td>";
	            			echo "</tr>";

	            		echo "</table>";
	            		
						
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

				$queryEditSiteTrees = "SELECT LPAD(treedata_site_trees.tree_id, 5, '0') AS treeID, treedata_tree_vitality.name AS treeVitality, treedata_tree_species.name AS treeSpecies
							FROM treedata_site_trees
							JOIN treedata_tree_species ON treedata_site_trees.species=treedata_tree_species.id
							JOIN treedata_tree_vitality ON treedata_site_trees.vitality=treedata_tree_vitality.id
							WHERE treedata_site_trees.shortcode='$siteShortcode'
							ORDER BY tree_id ASC";
        		$resultEditSiteTrees = mysqli_query ($connection, $queryEditSiteTrees);
		
        		//Check to see you have got at least 1 record 
        		if (mysqli_num_rows($resultEditSiteTrees) > 0) 
        		{
        				echo "<table class='siteDetailsTrees'>";
            			echo 	"<tr>";
            			echo 		"<th>Tree ID</th>";
            			echo 		"<th>Species</th>";
            			echo 		"<th>Vitality</th>";
            			echo 		"<th></th>";
            			echo 	"</tr>";

        			while($row = mysqli_fetch_array($resultEditSiteTrees, MYSQLI_ASSOC))
            		{
						echo "<form name='site_trees_edit' id='site_trees_edit".$row['treeID']."' method='GET' action='".$path."pages/admin/admin_site_tree_edit.php'>";  
						echo "<input type='hidden' name='siteShortcode' value='".$siteShortcode."'/>";
						echo "<input type='hidden' name='siteName' value='".$siteName."'/>";
						echo "<input type='hidden' name='treeID' value='".$row["treeID"]."'/>";
						echo "<input type='hidden' name='siteTreesEdit' value='1' />";
						echo "</form>";

						echo "<form name='site_trees_delete' id='site_trees_delete".$row['treeID']."' method='GET' action='".$path."pages/admin/admin_site_action.php'>";  
						echo "<input type='hidden' name='siteShortcode' value='".$siteShortcode."'/>";
						echo "<input type='hidden' name='siteName' value='".$siteName."'/>";
						echo "<input type='hidden' name='treeID' value='".$row["treeID"]."'/>";
						echo "<input type='hidden' name='siteTreesDelete'  value='1' />";
						echo "</form>";


						echo 	"<tr>";
            			echo 		"<td>".$row['treeID']."</td>";
            			echo 		"<td>".$row["treeSpecies"]."</td>";
            			echo 		"<td>".$row["treeVitality"]."</td>";
            			echo 		"<td>";
            			echo 			"<a href='javascript:{}' onclick=\"document.getElementById('site_trees_edit".$row['treeID']."').submit(); return false;\"><button>Edit</button></a>";
            			echo 			"&nbsp;";
            			echo 			"<a href='javascript:{}' onclick=\"document.getElementById('site_trees_delete".$row['treeID']."').submit(); return false;\"><button>Delete</button></a>";
            			echo 		"</td>";
               			echo 	"</tr>";
               			
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
