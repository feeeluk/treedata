<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Edit tree ";

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
		$siteTreeID=$_GET['treeID'];

	?>
          
			<div id="text">
                				
                <h2><?php echo $subTitle; ?> (<?php echo $siteName; ?>)</h2>
		
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

            			echo "<form class='treeEdit' method='GET' action='".$path."pages/admin/admin_site_action.php'>";
            			echo "<input type='hidden' name='siteName' id='' value='".$siteName."' />";
            			echo "<input type='hidden' name='siteShortcode' id='' value='".$siteShortcode."' />";
            			
            			echo "<table class='treeEdit'>";
            			
	            			echo "<tr>";
	            			echo 	"<td>Tree ID:</td>";
	            			echo 	"<td>".$row['treeID']."<input type='hidden' name='treeID' id='' value='".$row['treeID']."' /></td>";
	            			echo 	"<td rowspan='10'><img width='200' src='".$path."assets/images/site/".$siteShortcode."/tree/".$row['treeImage']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Latitude:</td>";
	            			echo 	"<td><input type='text' name='txt_treeLatitude' id='' value='".$row['treeLatitude']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Longitude:</td>";
	            			echo 	"<td><input type='text' name='txt_treeLongitude' id='' value='".$row['treeLongitude']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Map:</td>";
	            			echo 	"<td><a target='_blank' href='https://www.google.com/maps/search/?api=1&query=".$row['treeLatitude'].",".$row['treeLongitude']."'>link</a></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Age Class:</td>";
	            			echo 	"<td>";
	            			echo  		"<select name='select_treeAgeClass'>";
	            			echo 			"<option value='".$row['ageClassID']."'>".$row['ageClassName']."</option>";  

            					$queryAgeClass = "	SELECT id, name
													FROM treedata_tree_age_class";
            					$resultAgeClass = mysqli_query ($connection, $queryAgeClass);

	            				//Check to see you have got at least 1 record 
		        				if (mysqli_num_rows($resultAgeClass) > 0) 
		        				{  		         			
				
		        				while($rowAgeClass = mysqli_fetch_array($resultAgeClass, MYSQLI_ASSOC))
		        					{
		        						if($row['ageClassName'] == $rowAgeClass['name'])
		        						{

		        						}
		        						else
		        						{
		        							echo "<option value='".$rowAgeClass['id']."'>".$rowAgeClass['name']."</option>";
		        						}
		        					}
		        				}

		        				else
		        				{
		        					echo "<option>No data</option>";
		        				}

	            			echo		"</select>";
	            			echo 	"</td>";
	            			echo "</tr>";

	        				echo "<tr>";
	            			echo 	"<td>Species:</td>";
	            			echo 	"<td>";
	            			echo  		"<select name='select_treeSpecies'>";
	            			echo 			"<option value='".$row['speciesID']."'>".$row['speciesName']."</option>";  

            					$querySpecies = "	SELECT id, name
													FROM treedata_tree_species";
            					$resultSpecies = mysqli_query ($connection, $querySpecies);

	            				//Check to see you have got at least 1 record 
		        				if (mysqli_num_rows($resultSpecies) > 0) 
		        				{  		         			
				
		        				while($rowSpecies = mysqli_fetch_array($resultSpecies, MYSQLI_ASSOC))
		        					{
		        						if($row['speciesName'] == $rowSpecies['name'])
		        						{

		        						}
		        						else
		        						{
		        							echo "<option value='".$rowSpecies['id']."'>".$rowSpecies['name']."</option>";
		        						}
		        					}
		        				}
		        				else
		        				{
		        					echo "<option>No data</option>";
		        				}

	            			echo		"</select>";
	            			echo 	"</td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Height:</td>";
	            			echo 	"<td><input type='text' name='txt_treeHeight' id='' value='".$row['treeHeight']."' /></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Crown spread:</td>";
	            			echo 	"<td><input type='text' name='txt_treeCrownSpread' id='' value='".$row['treeCrownSpread']."' /></td>";
	            			echo 	"<td></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Stem Diameter:</td>";
	            			echo 	"<td><input type='text' name='txt_treeStemDiameter' id='' value='".$row['treeStemDiameter']."' /></td>";
	            			echo 	"<td></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Vitality:</td>";
	            			echo 	"<td>";
	            			echo  		"<select name='select_treeVitality'>";
	            			echo 			"<option value='".$row['vitalityID']."'>".$row['vitalityName']."</option>";  

            					$queryVitality = "	SELECT id, name
													FROM treedata_tree_vitality";
            					$resultVitality = mysqli_query ($connection, $queryVitality);

	            				//Check to see you have got at least 1 record 
		        				if (mysqli_num_rows($resultVitality) > 0) 
		        				{  		         			
				
		        				while($rowVitality = mysqli_fetch_array($resultVitality, MYSQLI_ASSOC))
		        					{
		        						if($row['vitalityName'] == $rowVitality['name'])
		        						{

		        						}
		        						else
		        						{
		        							echo "<option value='".$rowVitality['id']."'>".$rowVitality['name']."</option>";
		        						}
		        					}
		        				}
		        				else
		        				{
		        					echo "<option>No data</option>";
		        				}

	            			echo		"</select>";
	            			echo 	"</td>";	
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td>Observations:</td>";
	            			echo 	"<td colspan='2' rowspan='4'><textarea name='txt_treeDescription' id='' value=''>".$row['treeDescription']."</textarea><td>";
	            			echo "</tr>";

							echo "<tr>";
	            			echo 	"<td></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td></td>";
	            			echo "</tr>";

	            			echo "<tr>";
	            			echo 	"<td></td>";
	            			echo "</tr>";

							echo "<tr>";
	            			echo 	"<td></td>";
	            			echo 	"<td>";
	            			echo 		"<input type='submit' name='siteTreesEdit' value='Edit' />&nbsp;";
	            			echo 		"<input type='submit' name='siteTreesCancel' value='Cancel' />";
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
