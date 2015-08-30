<?php 	
	require_once('includes/connection.php'); 
	require_once('includes/functions.php'); 
	require_once('includes/session.php');
	logged_out();
	
	redirect_to(site_options('link').'login.php?logout=1');
	exit;


// close connection after logged out !
if(isset($connection)){
	mysql_close($connection);
}	
?>