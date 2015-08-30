<?php 

	require('../includes/connection.php');
	require('../includes/functions.php');
	require('../includes/form_functions.php');

	// Form validation
	$errors = array();
	
	$required_fields = array('subject_name','subject_position','subject_visible', 'subject_nav');

		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('subject_name' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
	
	
	if(!empty($errors)){
		redirect_to("new_subject.php?error=1");
	}
	
	$subject_name = mysql_prep($_POST['subject_name']);
	$subject_nav = mysql_prep($_POST['subject_nav']);
	$subject_position = mysql_prep($_POST['subject_position']);
	$subject_visible = mysql_prep($_POST['subject_visible']);
	$subject_content = mysql_prep($_POST['subject_content']);
	$subject_parent = mysql_prep($_POST['subject_parent']);
	
	if(isset($_POST['update'])){
		$update = mysql_prep($_POST['update']);
	}
	if(isset($_POST['add'])){
		$add = mysql_prep($_POST['add']);
	}
	if(isset($_POST['id'])){
	$id = mysql_prep($_POST['id']);
	}
	
	if(isset($update)){
		$query = "UPDATE page_subjects 
				SET nav_id = {$subject_nav}, 
				parent_id = {$subject_parent},
				position = {$subject_position}, 
				name = '{$subject_name}',
				content = '{$subject_content}',
				visible = {$subject_visible}
				 WHERE id={$id}";
	}
	elseif(isset($add)){
		$query = "INSERT INTO page_subjects (parent_id, nav_id, position, name, content, visible)
				VALUES ({$subject_parent},{$subject_nav},{$subject_position},'{$subject_name}','{$subject_content}',{$subject_visible})";
	}
	else{
		// do something
	}
	
	if($result_set = mysql_query($query, $connection)){
		//echo "Successful";
			if(isset($update)){
			redirect_to("subject_index.php?updated=1");
			}
			if(isset($add)){
			redirect_to("subject_index.php?added=1");
			}
			
			
		exit;
	}else{
		echo "failed: " . $query;
	}
	


mysql_close($connection);

?>