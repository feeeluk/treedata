<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "User Details";

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
		$isUserAdmin = "false";

		// include - header
		include($path."assets/includes/header.php");

		// include - login
		include($path."assets/includes/login.php");

	?>
          
			<div id="text">
                				
                <h2><?php echo $subTitle; ?></h2>
		
	            <p>

	            <?php

					$queryUser = "	SELECT *
									FROM treedata_users
									WHERE treedata_users.username='$username'";
            		$resultUser = mysqli_query ($connection, $queryUser);
			
            		//Check to see you have got at least 1 record 
            		if (mysqli_num_rows($resultUser) > 0) 
            		{
            			$row = mysqli_fetch_array($resultUser);

            			echo "<table class='userView'>";
	            			
	            			echo "<tr><td>Username:</td><td>".$row['username']."</td><td rowspan='9'><img width='200' src='".$path."assets/images/users/".$row['image']."' /></td></tr>";
	            			echo "<tr><td>First Name:</td><td>".$row['f_name']."</td></tr>";     			
	            			echo "<tr><td>Last Name:</td><td>".$row['l_name']."</td></tr>";
	            			echo "<tr><td>Address 1:</td><td>".$row['address_line_1']."</td></tr>";
	            			echo "<tr><td>Address 2:</td><td>".$row['address_line_2']."</td></tr>";
	            			echo "<tr><td>City:</td><td>".$row['city']."</td></tr>";
	            			echo "<tr><td>Postcode:</td><td>".$row['postcode']."</td></tr>";
	            			echo "<tr><td>Mobile:</td><td>".$row['mobile']."</td></tr>";
	            			echo "<tr><td>Admin?</td><td>";
	            			if($row['isAdmin'] == 0)
	            				{echo "no";}
	            			else
	            				{echo "yes"; $isUserAdmin="true";}
	            			echo "</td></tr>";
	            			echo "<tr><td></td><td><a href='".$path."pages/login/user_logged_on_edit_details.php'><button>Edit</button></a></td></tr>";

	            		echo "</table>";
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
