<?php 
	// This is the file where we place all basic functions.
	function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

// redirect function
function redirect_to($location = NULL){
	if($location != NULL){
	header("Location: {$location}");
	exit;
	}
}
	
// Confirm database query
function confirm_query($subject){
		if (!$subject) {
			die('Database Query Failed: ' . mysql_error());
		}
}	

// close database connection
function close_connection(){	
	global $connection;
	
	if(isset($connection)){
		mysql_close($connection);
		//echo "connection closed";
	}
}	

// get all site options
function site_options($option){
	global $connection;

	$query = "SELECT * FROM site_options";
	
	$options = mysql_query($query, $connection);
	confirm_query($options);
	
	while($opt = mysql_fetch_array($options)){
		
		if($option == 'link'
		|| $option == 'title'
		|| $option == 'description'
		|| $option == 'logo'
		|| $option == 'welcome'
		|| $option == 'new_products'
		|| $option == 'email'){
			return $opt[$option];
		}else{
			return NULL;
		}
	}
}	

// Create navigaiton for sidebar and main navigation
function get_navigation($nav_id, $nav){
	global $sel_subject;
	global $sel_page;	
	
	$subject_parent = get_main_subjects('parent');
	
	
	if($nav == 'sidebar'){
		while($subject = mysql_fetch_array($subject_parent)){
		
			if($subject['nav_id'] == $nav_id){
				echo '<li class="list-group-item  no-padding';
				
				
				if($subject['id'] == $sel_subject['id']){
					echo ' active">';
				}else {echo '">';}
				
				$link	=	'<a href="'. site_options('link') .'content.php?subject=' . urlencode($subject['id']) . '">';
				$link	.=	$subject['name'];
				$link	.=	'</a>';
				echo $link;
				echo '<ul>';
					
					$subject_child = get_main_subjects('child');
					while($child = mysql_fetch_array($subject_child)){


						if($subject['id'] == $sel_subject['id'] && $subject['id'] == $child['parent_id']){	
							
							$link	=	'<li><a ';
						
							$link	.=	'href="'. site_options('link') .'content.php?subject=' . urlencode($subject['id']) . '&child=' . urlencode($child['id']) . '">';
							$link	.=	$child['name'];
							$link	.=	'</a>';
							echo $link;
							echo '</li>';
						}				
					
					
					}
				
				/*$pages = get_subjects_for_pages($subject['id']);

				while($page = mysql_fetch_array($pages)){
					if($subject['id'] == $sel_subject['id']){	
						
						$link	=	'<li><a ';
					
						if($page['id'] == $sel_page['id']){
							$link .= 'class="active" ';
						}
						$link	.=	'href="'. site_options('link') .'content.php?subject=' . urlencode($subject['id']) . '&page=' . urlencode($page['id']) . '">';
						$link	.=	$page['page_name'];
						$link	.=	'</a>';
						echo $link;
						echo '</li>';
					}
				}*/
				
					echo '</ul>';
				
				
				echo '</li>';
			}					
		}
	}
	// top navigation
	elseif($nav == 'top'){
		while($subject = mysql_fetch_array($subject_parent)){
		
			if($subject['nav_id'] == $nav_id){
				echo '<li>';
				
				if($subject['id'] == $sel_subject['id']){
					echo '<li class="active">';
				}else{
					echo '<li>';
				}
				
				$link	=	'<a href="'. site_options('link') .'content.php?subject=' . urlencode($subject['id']) . '">';
				$link	.=	$subject['name'];
				$link	.=	'</a>';
				echo $link;
			echo '</li>';
			}	
			
		}			
	}
	else{
	
		echo '<li><a href="#">No Slot Selected</a></li>';
	
	}
}
	
// Get all Subjects	
function get_main_subjects($case){
	global $connection;
		
		switch($case){
			
			case'parent':
				$query = "SELECT * FROM page_subjects WHERE visible = 1 AND parent_id = 0 ORDER BY position ASC";
				break;
				
			case'child':
				$query = "SELECT * FROM page_subjects WHERE visible = 1 AND parent_id > 0 ORDER BY position ASC";
				break;				
			
			default:
				$query = "SELECT * FROM page_subjects WHERE visible = 1 ORDER BY position ASC";
				break;
		}
		$subject = mysql_query($query, $connection);
		confirm_query($subject);
		
	return $subject;
}

// Get all pages for navigation	
function get_subjects_for_pages($subject_id){
	global $connection;
		
		$query = "SELECT * 
				FROM page_data 
				WHERE subject_id = " . $subject_id . " AND visible = 1 ORDER BY position ASC";
		
		$page_data = mysql_query($query, $connection);
		confirm_query($page_data);
	return $page_data;
}

// get subjects by id
function get_subject_by_id($subject_id){

	global $connection;
	
		$query = "SELECT *";
		$query .= "	FROM page_subjects";
		$query .= "	WHERE id=" . $subject_id;
		$query .= " LIMIT 1";
		
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		
		if($subject = mysql_fetch_array($result_set)){
			return $subject;
		}else{
			return NULL;
		}

}

// get page data by id
function get_page_by_id($page_id){

	global $connection;
	
		$query = "SELECT *";
		$query .= "	FROM page_data";
		$query .= "	WHERE id=" . $page_id;
		$query .= " LIMIT 1";
		
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		
		if($page = mysql_fetch_array($result_set)){
			return $page;
		}else{
			return NULL;
		}

}

// get page data by id
function get_product_by_id($page_id = NULL, $product_id = NULL){

	global $connection;
	
		$query = "SELECT *";
		$query .= "	FROM products";
		if($page_id != NULL){
			$query .= "	WHERE page_id=" . $page_id;
		}else {
			$query .= "	WHERE id=" . $product_id;
		}
		$query .= " LIMIT 1";
		
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		
		if($page = mysql_fetch_array($result_set)){
			return $page;
		}else{
			return NULL;
		}

}









?>