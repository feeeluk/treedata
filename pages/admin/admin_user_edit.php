<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Edit User: ";

    // include - site details
    include($path."assets/includes/site_details.php"); 

	// include - connection
	include ($path."assets/includes/connection.php");

	// Check if we have an authenticated user & admin
	//if not re-direct to login page
	if (!isset($_SESSION["authenticated_user"]) && !isset($_SESSION["isAdmin"]))
	{
		$_SESSION["message"] = "please log in using an admin account";
		header("Location: $path");
	}
	
	else
	{ 
		//If authenticated then display page contents

		// get variables from form
		$usernameToUpdate = $_GET["username"];

		// include - header
		include($path."assets/includes/header.php");

		// include - login
		include($path."assets/includes/login.php");

	?>
          
			<div id="text">
                				
            	<h2><?php echo $subTitle; ?> <?php echo $usernameToUpdate; ?></h2>
				
				<p>
				
					<?php
					
						// create query 
						$queryDetails = "	SELECT *
											FROM treedata_users
											WHERE treedata_users.username='$usernameToUpdate'";
					
						// execute query - put the results in $result (an array) 
						$queryDetailsResult = mysqli_query($connection, $queryDetails) or die ("Error in query: $queryDetails. ".mysqli_error());
					
						// Check to see you have got at least 1 record 
						// print out record details on a form 
						if (mysqli_num_rows($queryDetailsResult) > 0) 
						{
							$row = mysqli_fetch_array($queryDetailsResult);
					    
					?>
						
					<form class="userEdit" name="amend_delete_details" id="amend_delete_details" method="GET" action="<?php echo $path; ?>pages/admin/admin_users_action.php">  
					<input type="hidden" name="username" value="<?php echo $row["username"]; ?>"/>

					<table class="userEdit">

						<tr>
							<td>First Name:</td>
							<td><input type="text" id="" name="txt_f_name" value="<?php echo $row["f_name"]; ?>"/>
							</td>
							<td rowspan='7'><img src="<?php echo $path; ?>assets/images/users/<?php echo $row["image"]; ?>" width="200" /></td>
						</tr>	

						<tr>
							<td>Last Name:</td>
							<td><input type="text" id="" name="txt_l_name" value="<?php echo $row["l_name"]; ?>"/>
							</td>
						</tr>		

						<tr>
							<td>Address 1:</td>
							<td><input type="text" id="" name="txt_address_line_1" value="<?php echo $row["address_line_1"]; ?>"/>
							</td>
						</tr>	

						<tr>
							<td>Address 2:</td>
							<td><input type="text" id="" name="txt_address_line_2"  value="<?php echo  $row["address_line_2"]; ?>"/>
							</td>
						</tr>	

						<tr>
							<td>City:</td>
							<td><input type="text" id="" name="txt_city"  value="<?php echo  $row["city"]; ?>"/>
							</td>
						</tr>

						<tr>
							<td>Postode:</td>
							<td><input type="text" id="" name="txt_postcode"  value="<?php echo  $row["postcode"]; ?>"/>
							</td>
						</tr>

						<tr>
							<td>Mobile:</td>
							<td><input type="text" id="" name="txt_mobile"  value="<?php echo  $row["mobile"]; ?>"/>
							</td>
						</tr>


						<tr>
							<td></td>
							<td>
								<input name="editUser" type="submit" value="Edit" />
								<input name="cancel" type="submit" value="Cancel" />
							</td>
						</tr>

					</table>

					</form>

					<?php

						//Otherwise no rows found 
						}
						
						else 
						{
							echo "No rows found"; 
						
							// Close the DBMS connection 
							mysqli_close($connection);
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
