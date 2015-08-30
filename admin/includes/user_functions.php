<?php 

// Get users for admin	
function get_users_for_admin($count = false){
	global $connection;
		
		if($count == true){
			$query = "SELECT COUNT(*) FROM users ORDER BY id ASC";
		}else {
			$query = "SELECT * FROM users ORDER BY id ASC";
		}
		
		$page_data = mysql_query($query, $connection);
		confirm_query($page_data);
	return $page_data;
}

// get user by id
function get_user_by_id($user_id){

	global $connection;
	
		$query = "SELECT *";
		$query .= "	FROM users";
		$query .= "	WHERE id=" . $user_id;
		$query .= " LIMIT 1";
		
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		
		if($user = mysql_fetch_array($result_set)){
			return $user;
		}else{
			return NULL;
		}

}

function get_user_by_status($case){
	global $connection;
	switch($case){
		
		case "inactive":
			$query = "SELECT * FROM users WHERE activation = 0 ORDER BY id DESC";	
		break;	
		
		case "active":
			$query = "SELECT * FROM users WHERE activation = 1 ORDER BY id DESC";	
		break;	
	
	}
	
	$page_data = mysql_query($query, $connection);
	confirm_query($page_data);
	return $page_data;	
}

// admin subjects index
function admin_user_index(){
	
	$pagination = pagination(15,'users');
		
	$subject_index = '<table class="table table-hover table-bordered">';
	$subject_index .= '<tr><th>ID</th><th>Name</th><th>Activation</th><th>User type</th><th>Modification</th></tr>';
	
	while($subject = mysql_fetch_array($pagination['query'])){
	
		$subject_index .= '<tr>';
		
		$subject_index .= '<td>' . $subject['id'] . '</td>';
		$subject_index .= '<td>' . $subject['username'] . '</td>';
		if($subject['activation'] == 1){
			$subject_index .= '<td>Yes</td>';
		}else{
			$subject_index .= '<td>No</td>';
		}
		
		if($subject['user_type'] == 1){
			$subject_index .= '<td>Admin</td>';
		}elseif($subject['user_type'] == 2){
			$subject_index .= '<td>Customer</td>';
		}else{
			$subject_index .= '<td>'. $subject['user_type'] .'</td>';
		}		
		

		$subject_index .= '<td><a href="'. site_options('link') .'admin/edit_user.php?user='. $subject['id'] .'">Edit </a>';
		$alert = "'Are you sure you want to delete this page?'";
		$subject_index .= '/&nbsp;<a href="'. site_options('link') .'admin/delete_user.php?user='. $subject['id'] .'" onclick="return confirm('.$alert.');">Delete</a></td>';
		
			
		
		$subject_index .= '</tr>';
					
	}
	$subject_index .= '</table>';
	

			$subject_index .= $pagination['index'];	


	return $subject_index;
}




?>