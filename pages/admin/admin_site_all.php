<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "All Sites";

    // include - site details
    include($path."assets/includes/site_details.php"); 

	// include - connection
	include ($path."assets/includes/connection.php");

	// Check if we have an authenticated user & admin
	//if not re-direct to login page
	if (!isset($_SESSION["authenticated_user"]) && !isset($_SESSION["isAdmin"]))
	{
		$_SESSION["message"] = "please log in with an admin account";
		header("Location: $site");
	}
	
	else
	{ 
		//If authenticated then display page contents

		$username = $_SESSION["authenticated_user"];

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
									FROM treedata_sites";
									
	            		$result = mysqli_query ($connection, $query);
				
		        		//Check to see you have got at least 1 record 
		        		if (mysqli_num_rows($result) > 0) 
		        		{

	        			    echo "<table class='sitesAll'>";
	            			echo 	"<tr>";
	            			echo 		"<th>Name</th>";
	            			echo 		"<th>Shortcode</th>";
	            			echo 		"<th></th>";
	            			echo 	"</tr>";

							while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		            		{
		            			echo "<form action='".$path."pages/admin/admin_site_view.php' method='GET' name='siteEdit".$row['shortcode']."'id='siteEdit".$row['shortcode']."'>";
		            			echo "<input type='hidden' name='siteShortcode' id='siteShortcode' value='".$row['shortcode']."'>";
		            			echo "<input type='hidden' name='siteName' id='siteName' value='".$row['name']."'>";
		            			echo "<input type='hidden' name='siteEdit' value='1' />";
		            			echo "</form>";

		            			echo "<form action='".$path."pages/admin/admin_site_action.php' method='GET' name='siteDelete".$row['shortcode']."'id='siteDelete".$row['shortcode']."'>";
		            			echo "<input type='hidden' name='siteShortcode' id='siteShortcode' value='".$row['shortcode']."'>";
			            		echo "<input type='hidden' name='siteDelete' value='1' />";
			            		echo "</form>";

		            			echo "<tr>";
			            			echo "<td>";
			            			echo $row['name'];
			            			echo "</td>";

			            			echo "<td>";
			            			echo $row['shortcode'];
			            			echo "</td>";

	            					echo "<td>";
			            			echo "<a href='javascript:{}' onclick=\"document.getElementById('siteEdit".$row['shortcode']."').submit(); return false;\"><button>Edit</button></a>";
			            			echo "&nbsp;";
			            			echo "<a href='javascript:{}' onclick=\"document.getElementById('siteDelete".$row['shortcode']."').submit(); return false;\"><button>Delete</button></a>";					
			            			echo "</td>";
			            		echo "</tr>";
				            		           	
		            		}

				            echo "</table>";
						}
	                
		                else               
		                {
		                	echo "<p>No details found </p>";
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
