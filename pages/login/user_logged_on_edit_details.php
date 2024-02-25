<?php
session_start();

    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "../../";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Edit Details";

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

	//If authenticated then display page conetents
	else
		{ 

		$username = $_SESSION['authenticated_user'];

		// include - header
		include($path."assets/includes/header.php");

		// include - login
		include($path."assets/includes/login.php");

	?>
            
			<div id="text">
            	
            	<h2><?php echo $subTitle; ?></h2>
				
				<p>
				
				<?php
			
					// create query 
					$details_query = "	SELECT *
										FROM treedata_users
										WHERE treedata_users.username='$username'";
				
					// execute query - put the results in $result (an array) 
					$details_query_result = mysqli_query($connection, $details_query) or die ("Error in query: $details_query. ".mysqli_error());
				
					// Check to see you have got at least 1 record 
					// print out record details on a form 
					if (mysqli_num_rows($details_query_result) > 0) 
					{
					$details_row = mysqli_fetch_array($details_query_result);
					    
				?>
			
					<form class="userEdit" name="amend_delete_details" id="amend_delete_details" method="GET" action="<?php echo $path ?>pages/login/user_logged_on_edit_details_action.php"> 
					<input type="hidden" name="txt_username" value="<?php echo $details_row["username"]; ?>"/>
						
					<table class="userEdit">

						<tr>
							<td>Username:</td>
							<td><input style="pointer-events:none;" type="text" id="" name="" value="<?php echo $username; ?>"/></td>
							<td rowspan='9'><img src="<?php echo $path; ?>assets/images/users/<?php echo $details_row["image"]; ?>" width="200" /></td>
						</tr>

						<tr>
							<td>First Name:</td>
							<td><input type="text" id="" name="txt_f_name" value="<?php echo $details_row["f_name"]; ?>"/></td>
						</tr>	

						<tr>
							<td>Last Name:</td>
							<td><input type="text" id="" name="txt_l_name" value="<?php echo $details_row["l_name"]; ?>"/></td>
						</tr>		

						<tr>
							<td>Address 1:</td>
							<td><input type="text" id="" name="txt_address_line_1" value="<?php echo $details_row["address_line_1"]; ?>"/></td>
						</tr>	

						<tr>
							<td>Address 2:</td>
							<td><input type="text" id="" name="txt_address_line_2"  value="<?php echo  $details_row["address_line_2"]; ?>"/></td>
						</tr>	

						<tr>
							<td>City:</td>
							<td><input type="text" id="" name="txt_city"  value="<?php echo  $details_row["city"]; ?>"/></td>
						</tr>

						<tr>
							<td>Postcode:</td>
							<td><input type="text" id="" name="txt_postcode"  value="<?php echo  $details_row["postcode"]; ?>"/></td>
						</tr>

						<tr>
							<td>Mobile:</td>
							<td><input type="text" id="" name="txt_mobile"  value="<?php echo  $details_row["mobile"]; ?>"/></td>
						</tr>

						<tr>
							<td>Admin?</td>
							<td>
								<?php 
								if($details_row['isAdmin'] == 0)
            						{echo "no";}
            					else
            						{echo "yes";}
            					?>
            				</td>
            			</tr>

            			<tr>
            				<td></td>
            				<td>
            					<input name="edit" type="submit" value="Edit" />
            					<input name="cancel" type="submit" value="Cancel" />
            				</td>
            			</tr>

					</table>

					</form>

				<?php

					//Otherwise no rows found 
					// end if
					}
					
					else echo "No rows found"; 
					
					// Close the DBMS connection 
					mysqli_close($connection);

				?>
			</p>
                
		</div>
			
	</div>
		
</body>

</html>

<?PHP

	}
	
?>
