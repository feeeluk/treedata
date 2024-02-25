<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Tree Details";

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
		$siteTreeID = $_GET['siteTreeID'];

		// include - header
		include($path."assets/includes/header.php");

		// include - login
		include($path."assets/includes/login.php");

	?>
          
			<div id="text">
                				
                <h2>Site: <?php echo $siteName; ?></h2>
                <p>
		
	             <?php

					$query = "	SELECT 	LPAD(ST.tree_id, 5, '0') AS treeID,
										ST.description AS treeDescription,
								        ST.latitude AS treeLatitude,
								        ST.longitude AS treeLongitude,
								        ST.image AS treeImage,
								        ST.crown_spread AS treeCrownSpread,
								        ST.stem_diameter AS treeStemDiameter,
								        ST.height AS treeHeight,
										S.id AS speciesID,
								        S.name AS speciesName,
								        V.id AS vitalityID,
								        V.name AS vitalityName,
								        V.description AS vitalityDescription,
								        AC.id AS ageClassID,
								        AC.name AS ageClassName,
								        AC.description AS ageClassDescription
								FROM 	treedata_site_trees ST
								JOIN 	treedata_tree_species S ON S.id = ST.species
								JOIN 	treedata_tree_vitality V ON V.id = ST.vitality
								JOIN 	treedata_tree_age_class AC ON AC.id = ST.age_class
								WHERE 	ST.shortcode = '$siteShortcode'
								AND 	ST.tree_id='$siteTreeID'";

            		$result = mysqli_query ($connection, $query);
			
            		//Check to see you have got at least 1 record 
            		if (mysqli_num_rows($result) > 0) 
            		{
            			$row = mysqli_fetch_array($result);

            			echo "<form name='' id='siteDetails' method='GET' action='".$path."pages/login/user_logged_on_site_details.php'>";
            			echo "<input type='hidden' name='siteShortcode' id='siteShortcode' value='".$siteShortcode."' />";
            			echo "<input type='hidden' name='siteName' id='siteName' value='".$siteName."' />";

            			echo "<table class='treeView'>";
	            			
	            			echo "<tr><td>Tree ID:</td><td>".$row['treeID']."</td><td rowspan='10'><img width='200' src='".$path."assets/images/site/".$siteShortcode."/tree/".$row['treeImage']."' /></td></tr>";
	            			echo "<tr><td>Latitude:</td><td>".$row['treeLatitude']."</td></tr>";
	            			echo "<tr><td>Longitude:</td><td>".$row['treeLongitude']."</td></tr>";
	            			echo "<tr><td>Map:</td><td><a target='_blank' href='https://www.google.com/maps/search/?api=1&query=".$row['treeLatitude'].",".$row['treeLongitude']."'>link</a></td></tr>";     			
	            			
	            			echo "<tr><td>Age Class:</td><td>".$row['ageClassName']."</td></tr>";
							echo "<tr><td>Species:</td><td>".$row['speciesName']."</td></tr>";
	            			echo "<tr><td>Height</td><td>".$row['treeHeight']."</td></tr>";
	            			echo "<tr><td>Crown Spread</td><td>".$row['treeCrownSpread']."</td></tr>";
	            			echo "<tr><td>Stem Diameter</td><td>".$row['treeStemDiameter']."</td></tr>";
	            			echo "<tr><td>Vitality:</td><td>".$row['vitalityName']."</td></tr>";
	            			echo "<tr><td>Observations:</td><td colspan='2'>".$row['treeDescription']."</td></tr>";	            			
	            			
	            			echo "<tr>";
	            			echo 	"<td></td>";
	            			echo 	"<td><button type='submit' formid='Details'>View site</button></td>";
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
