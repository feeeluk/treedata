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


    // every page can have a different title
    $subTitle = "Search results";

	// set variables
	$search = $_GET["txt_search"];
	$search = intval($search);

	$query = "	SELECT treedata_site_trees.tree_id AS treeID, treedata_sites.name AS sitename, treedata_sites.shortcode AS shortcode FROM treedata_site_trees
				JOIN treedata_sites ON treedata_sites.shortcode = treedata_site_trees.shortcode
				WHERE tree_id LIKE '$search'";

	$result = mysqli_query ($connection, $query);

    			
	if(mysqli_num_rows($result) == 1)
	{
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		// redirect the location
		header("Location: ".$path."pages/login/user_logged_on_site_tree_details.php?siteName=".$row['sitename']."&siteShortcode=".$row['shortcode']."&siteTreeID=".$row['treeID']);
	}

	else
	{
		// include - header
		include($path."assets/includes/header.php");

		// include - login
		include($path."assets/includes/login.php");

			echo "<div id='text'>";
		        				
		        echo "<h2>".$subTitle."</h2>";

		        echo "<p>";

			        if (mysqli_num_rows($result) > 1)
			        {

	                	echo "<table>";

							echo "<tr>";
								echo "<td>";
									echo "There are several trees with this ID. Which site do you want?";
								echo "</td>";
								echo "</tr>";

						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
						{
							echo "<tr>";
								echo "<td>";
									echo "<a href='".$path."pages/login/user_logged_on_site_tree_details.php?siteName=".$row['sitename']."&siteShortcode=".$row['shortcode']."&siteTreeID=".$row['treeID']."'>".$row['sitename']."</a>";
								echo "</td>";
							echo "</tr>";
						}


						echo "</table>";

					}

					else
					{
						echo "no results";		
					}

				echo "</p>";
                
			echo "</div>";
			
		echo "</div>";
		
	echo "</body>";

echo "</html>";
	}
?>