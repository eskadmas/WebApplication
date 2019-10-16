<?php
if (!isset($_SESSION["time"])){
  	header("Location:login.php"); 
}
else {
 	
	if ((time() - $_SESSION["time"]) > 120) { // with inactivity period too long 
	    session_unset(); 	// empty session
	    session_destroy();  // destroy session
	    // redirect client to login page
		header("Location:login.php"); 
		exit; 
	} 
	else {
	   $_SESSION["time"]=time();
	}
}

?>
