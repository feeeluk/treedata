<?php
session_start();

    
    // SET PAGE SPECIFIC VARIABLES

    // set the root folder (site root not server root) in relation to this page
    $path = "./";       
            // ./ = this page is located in the root directory
            // ../ = this page is located one folder up
            // ../../ = this page is located two folders up, etc.
    
    // every page can have a different title
    $subTitle = "Home";

    // include - site details
    include($path."assets/includes/site_details.php"); 

	// include - header
    include($path."assets/includes/header.php");

    // include - login
    include($path."assets/includes/login.php");

?>
         
			<div id="text">
      	
      			<h2>Test system</h2>
				
				<p>
					To see a quick example of what can be done, log into the site using the following account details (this would replicate what a customer does / sees).
				</p>

				<p>
					Account = "Dave", or "John", or "Robert", or "Steve", or "Loz"
					<br>
					Password = "test"
				</p>
            
	        	<p>
	        		** Loz = administrative account ** 
	        	</p>
                
			</div>
			
		</div>
		
	</body>

</html>
