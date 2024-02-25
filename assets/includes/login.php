			<div id="userLogin">

  			<?php

				if (isset($_SESSION["authenticated_user"])) 
				{
					$username = $_SESSION['authenticated_user'];
					echo "<h2>".$username."</h2>";
					echo "<ul>";
					echo "<li><a href='".$path."pages/login/user_logged_on.php'>user details</a></li>";
            		echo "<li><a href='javascript:{}' onclick=\"document.getElementById('".$username."').submit(); return false;\">edit details</a></li>";
					echo "<li><a href='".$path."pages/login/user_logged_on_sites.php' class='link'>sites</a></li>";
					echo "<li><a href='".$path."pages/login/user_logout.php' class='link'>logout</a></li>";
					echo "</ul>";
					echo "<form action='".$path."pages/login/user_logged_on_edit_details.php' method='POST' name='".$username."' id='".$username."'>";
            		echo "<input type='hidden' id='username' name='username' value='".$username."'>";
            		echo "</form>";
					
					if($_SESSION["isAdmin"] == "true")
					{
						echo "<h2>Admin section</h2>";
						echo "<ul style='list-style-type:square;''>";
						echo "<li><a href='".$path."pages/admin/admin_sites_all.php'>all sites</a></li>";
						echo "<li><a href='".$path."pages/admin/admin_users_all.php'>all users</a></li>";
						echo "<li><a href='".$path."pages/settings/settings.php'>settings</a></li></li>";
						echo "</ul>";
					}
				}

				else
				{
					echo "<h2>Sign In</h2>";
					echo "<p><form action='".$path."pages/login/user_login_action.php' method='POST' name='login' id='login' >";
					echo "Username:";
					echo "<br>";
					echo "<input type='text' id='form' name='username'>";
					echo "<br>";
					echo "Password:";
					echo "<br>";
					echo "<input type='password' id='form' name='password'>";
					echo "<br>";
					echo "<input id='submit' name='submit' type='submit' value='login'>";
					echo "</form></p>";
					// echo "<a href='".$path."pages/register.php' class='link'>register</a>";
				}

				if (isset($_SESSION["message"]))
				{
					echo "<div id='message'>".$_SESSION["message"]."</div>";
					echo "<script src='".$path."assets/scripts/index.js'></script>";
					unset($_SESSION['message']);
				}

			?>

			</div>