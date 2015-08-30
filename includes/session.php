<?php 
	
	session_start();
	ob_start();
	
	function logged_in() {
		return isset($_SESSION['user_id']);
	}	
	
	function logged_out() {
		$_SESSION = array();
		session_unset();
		session_destroy();
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to(site_options('link').'login.php');
		}
	}
	
	function confirm_admin() {
		if ($_SESSION['user_type'] != 1) {
			redirect_to(site_options('link').'index.php');
		}
	}	
	

?>