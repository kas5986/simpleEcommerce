<?php 

// Get all pages for admin	
function get_subjects_for_admin($count = false){
	global $connection;
		
		if($count == true){
			$query = "SELECT COUNT(*) FROM page_subjects ORDER BY id ASC";
		}else {
			$query = "SELECT * FROM page_subjects ORDER BY id ASC";
		}
		
		$page_data = mysql_query($query, $connection);
		confirm_query($page_data);
	return $page_data;
}

// admin subjects index
function admin_subject_index(){
	
	$pagination = pagination(15,'subjects');
		
	$subject_index = '<table class="table table-hover table-bordered">';
	$subject_index .= '<tr><th>Name</th><th>Navigation ID</th><th>Position</th><th>Visible</th><th>Modification</th></tr>';
	
	while($subject = mysql_fetch_array($pagination['query'])){
	
		$subject_index .= '<tr>';
		
		$subject_index .= '<td>' . $subject['name'] . '</td>';
		
		$subject_index .= '<td>'; 
		if($subject['nav_id'] == 1){
			$subject_index .= $subject['nav_id'] = 'Sidebar'; 
		}else{
			$subject_index .= $subject['nav_id'] = 'Top'; 
		}
		$subject_index .= '</td>';
		
		$subject_index .= '<td>' . $subject['position'] . '</td>';
		
		$subject_index .= '<td>';
		
		if($subject['visible'] == 1){
			$subject_index .= $subject['visible'] = 'Yes' ;
		}else{
			$subject_index .= $subject['visible'] = 'No' ;
		}
		
		$subject_index .= '</td>';
		
		//$subject_index .= '<td>' . $subject['visible'] = 'Yes' . '</td>';
		$subject_index .= '<td><a href="'. site_options('link') .'admin/edit_subject.php?subject='. $subject['id'] .'">Edit </a>';
		$alert = "'Are you sure you want to delete this page?'";
		$subject_index .= '/&nbsp;<a href="'. site_options('link') .'admin/delete_subject.php?subject='. $subject['id'] .'" onclick="return confirm('.$alert.');">Delete</a></td>';
		
			
		
		$subject_index .= '</tr>';
					
	}
	$subject_index .= '</table>';
	

			$subject_index .= $pagination['index'];	


	return $subject_index;
}

?>