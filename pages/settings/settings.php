<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Settings";

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
                	<ul>
                		<li>Trees
                			<ul>
                				<li>Species</li>
                				<li>Age class</li>
                				<li>Vitality</li>
                			</ul>
                		</li>

                		<li>Sites
                			<ul>
                				<li>Add a new site</li>
                				<li>Add a new tree to an existing site</li>
                			</ul>
                		</li>

                		<li>Users
                			<ul>
                				<li>Add a new user</li>
                			</ul>
                		</li>
                	</ul>

                	<?php
                
            		?>

    			</p>
                
			</div>
			
		</div>
		
	</body>

</html>

<?php

	}

?>
