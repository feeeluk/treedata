<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "All Users";

    // include - site details
    include($path."assets/includes/site_details.php"); 

	// include - connection
	include ($path."assets/includes/connection.php");

	// Check if we have an authenticated user & admin
	//if not re-direct to login page
	if (!isset($_SESSION["authenticated_user"]) && !isset($_SESSION["isAdmin"]))
	{
		$_SESSION["message"] = "please log in using an admin account";
		header("Location: $site");
	}
	
	else
	{ 
		//If authenticated then display page contents;

		// include - header
		include($path."assets/includes/header.php");

		// include - login
		include($path."assets/includes/login.php");

	?>
          
			<div id="text">
                				
                <h2><?php echo $subTitle; ?></h2>
		
                <p>
                	<?php

						$query = "	SELECT treedata_users.username, treedata_users.f_name, treedata_users.l_name, treedata_users.isAdmin
								FROM treedata_users ORDER BY username ASC";
	            		$result = mysqli_query ($connection, $query);
				
		        		//Check to see you have got at least 1 record 
		        		if (mysqli_num_rows($result) > 0) 
		        		{

	        				echo "<table class='usersAll'>";
	            			echo 	"<tr>";
	            			echo 		"<th>Username</th>";
	            			echo 		"<th>Admin</th>";
	            			echo 		"<th></th>";
	            			echo 	"</tr>";

							while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		            		{
		            			if($row['username'] == $username)
		            			{

		            			}
		            			else
		            			{		            			
		            				echo "<form action='".$path."pages/admin/admin_user_edit.php' method='GET' name='editUser".$row['username']."' id='editUser".$row['username']."'>";
            						echo "<input type='hidden' id='' name='username' value='".$row['username']."' />";
		            				echo "</form>";

			            			echo "<form action='".$path."pages/admin/admin_users_action.php' method='GET' name='deleteUser".$row['username']."' id='deleteUser".$row['username']."'>";
            						echo "<input type='hidden' id='' name='username' value='".$row['username']."' />";  
            						echo "<input type='hidden' id='' name='deleteUser' value='1' />";           					
		            				echo "</form>";

			            			echo "<tr>";
				            			echo "<td>";
				            			echo 	$row['username'];
				            			echo "</td>";

				            			echo "<td>";
				            			if($row['isAdmin'] == 0)
				            				{echo "no";}
				            				else
				            				{echo "yes";}
				            			echo "</td>";

		            					echo "<td>";
				            			echo 	"<a href='javascript:{}' onclick=\"document.getElementById('editUser".$row['username']."').submit(); return false;\"><button>Edit</button></a>";
				            			echo 	"&nbsp;";
				            			echo 	"<a href='javascript:{}' onclick=\"document.getElementById('deleteUser".$row['username']."').submit(); return false;\"><button>Delete</button></a>";
				            			echo "</td>";
				            		echo "</tr>";
			            		}
				            		           	
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
