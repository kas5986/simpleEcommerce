<?php 
/*-----------------------------------------------
*	Project 		:	LongHorn Vapor Co.
*	Author			:	Syed Muhammad Shafiq
*	File name		:	page_functions.php
*	File Details	:	This file is for all known functions regarding admin pages settings !
*	
*------------------------------------------------*/

// to get all pages for admin !
function get_pages_for_admin($count = false){
	global $connection;
		
		if($count == true){
			$query = "SELECT COUNT(*) FROM page_data ORDER BY id ASC";
		}else {
			$query = "SELECT * FROM page_data ORDER BY id ASC";
		}
		
		$page_data = mysql_query($query, $connection);
		confirm_query($page_data);
	return $page_data;
}

// Generate full html table for admin index !
function admin_page_index(){

	$pagination = pagination(15,'pages');
	
	$page_index = '<table class="table table-hover table-bordered">';
	$page_index .= '<tr><th>Name</th><th>Subject</th><th>Position</th><th>Visible</th><th>Product</th><th>Modification</th></tr>';
	
	while($page = mysql_fetch_array($pagination['query'])){
	
		$page_index .= '<tr>';
		
		$page_index .= '<td>' . $page['page_name'] . '</td>';
		
		// to get page name and its id start
		global $connection;
		$query = "SELECT name FROM page_subjects WHERE id=" . $page['subject_id'];
		$subject_set = mysql_query($query, $connection);
		confirm_query($subject_set);
		
		while($subject = mysql_fetch_array($subject_set)){
			$page_index .= '<td>' . $subject['name']  . '</td>';
		}
		// get page name from id end
		
		
		$page_index .= '<td>' . $page['position'] . '</td>';
		
		if($page['visible'] == 1){
			$page_index .= '<td>' . $page['visible'] = 'Yes' . '</td>' ;
		}else{
			$page_index .= '<td>' . $page['visible'] = 'No' . '</td>' ;
		}

		// to get product
		global $connection;
		$query = "SELECT * FROM products WHERE page_id=" . $page['id'];
		$product_set = mysql_query($query, $connection);
		confirm_query($product_set);
		$pro_id = 0;
		$pro = 'No';
		while($product = mysql_fetch_array($product_set)){
			if($product['page_id'] == $page['id']){
				$pro = $product['name'];
				$pro_id = $product['id'];
			}		
		}
		// get products

		
		if($pro != 'No'){
			$page_index .= '<td>'.$pro.'</td>' ;
		}else{
			$page_index .= '<td>No</td>' ;
		}		
		
		
		$page_index .= '<td><a href="'. site_options('link') .'admin/edit_page.php?page='. $page['id'] .'">Edit</a>&nbsp;';
		$alert = "'Are you sure you want to delete this page?'";
		$page_index .= '/&nbsp;<a href="'. site_options('link') .'admin/delete_page.php?page='. $page['id'];
		/*if($pro_id != 0){
			$page_index .='&product='.$pro_id;
		}*/
		$page_index .='" onclick="return confirm('.$alert.');">Delete</a></td>';
		
			
		
		$page_index .= '</tr>';
					
	}
	$page_index .= '</table>';
	$page_index .= $pagination['index'];
	return $page_index;

}

?>