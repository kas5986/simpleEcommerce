<?php 

	require('../includes/connection.php');
	require('../includes/functions.php');

	// Form validation
	$errors = array();
	// for logo file upload
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["logo_file"]["name"]);	
	$extension = end($temp);	
	
	$required_fields = array('site_title','site_url');
	
	foreach($required_fields as $fieldname){		
		if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
			$errors[] = $fieldname;
		}	
	}
	
	$fields_with_lengths = array('site_title' => 30);
	foreach($fields_with_lengths as $fieldname => $maxlength ) {
		if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { $errors[] = $fieldname; }
	}	
	
	if(!empty($errors)){
		redirect_to("index.php?error=general_settings");
	}	


	$site_title = mysql_prep($_POST['site_title']);
	$site_url = mysql_prep($_POST['site_url']);
	$site_email = mysql_prep($_POST['site_email']);
	$site_description = mysql_prep($_POST['site_description']);
	$site_logo = '';
	$site_ppr = mysql_prep($_POST['site_ppr']);
	$site_welcome = mysql_prep($_POST['site_welcome']);
	$oid = mysql_prep($_POST['id']);



	if ((($_FILES["logo_file"]["type"] == "image/gif")
	|| ($_FILES["logo_file"]["type"] == "image/jpeg")
	|| ($_FILES["logo_file"]["type"] == "image/jpg")
	|| ($_FILES["logo_file"]["type"] == "image/pjpeg")
	|| ($_FILES["logo_file"]["type"] == "image/x-png")
	|| ($_FILES["logo_file"]["type"] == "image/png"))
	&& ($_FILES["logo_file"]["size"] <= 1024*500)
	&& in_array($extension, $allowedExts)){
		
		if ($_FILES["logo_file"]["error"] > 0){
			//handle if file have errors
			echo "Return Code: " . $_FILES["logo_file"]["error"] . "<br>";
			//redirect_to("/w-sell");
			exit;
		}else{

			if (file_exists("../images/" . $_FILES["logo_file"]["name"])){
			  $site_logo = "/images/" . $_FILES["logo_file"]["name"];
			}else{
			  $_FILES["logo_file"]["name"] = sha1($_FILES["logo_file"]["name"]). '.' .$extension;
			  move_uploaded_file($_FILES["logo_file"]["tmp_name"], "../images/" . $_FILES["logo_file"]["name"]);
			  $site_logo = "/images/" . $_FILES["logo_file"]["name"];
			}
		}	
	
	}else{
		if($_FILES["logo_file"]["size"] >= 1024*500){
			echo "more than 500 kb !";
			exit;
		}
		// handle if no file found to upload !
		$site_logo = mysql_prep($_POST['site_logo']);
		//echo "invalid file";
	}


	$query = "UPDATE site_options SET title='";
	$query .= $site_title ;
	$query .= "', link='" ;
	$query .= $site_url ;
	$query .= "', email='" ;
	$query .= $site_email ;
	$query .= "', logo='" ;
	$query .= $site_logo ;
	$query .= "', new_products='" ;
	$query .= $site_ppr ;
	$query .= "', description='" ; 
	$query .= $site_description ;
	$query .= "', welcome='" ; 
	$query .= $site_welcome ;
	$query .= "' WHERE id=" . $oid ;
	
	if($result_set = mysql_query($query, $connection)){
		echo "Successful";
		redirect_to("admin_options.php?success=1");
		exit;
	}else{
		echo "failed: " . $query;
	}
	

mysql_close($connection);

?>