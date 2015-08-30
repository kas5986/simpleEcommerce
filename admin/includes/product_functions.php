<?php 
// Get all pages for admin	
function get_products_for_admin($count = false){
	global $connection;
		if($count == true){
			$query = "SELECT COUNT(*) FROM products ORDER BY id ASC";
		}else {
			$query = "SELECT * FROM products ORDER BY id ASC";
		}
		
		$page_data = mysql_query($query, $connection);
		confirm_query($page_data);
	return $page_data;
}

// Get all pages for admin	
function get_products_for_cat($cat){
	global $connection;
			$query = "SELECT COUNT(*) FROM products WHERE subject_id = $cat ORDER BY id ASC";

		$page_data = mysql_query($query, $connection);
		confirm_query($page_data);
	return $page_data;
}



// admin subjects index
function admin_products_index(){

	$pagination = pagination(15,'products');
	
	$product_index = '<table class="table table-hover table-bordered">';
	$product_index .= '<tr><th>Product#</th><th>Name</th><th>Page</th><th>Position</th><th>Visible</th><th>Price</th><th>Modification</th></tr>';
	
	while($product = mysql_fetch_array($pagination['query'])){
	
		$product_index .= '<tr>';
		$product_index .= '<td>' . $product['id'] . '</td>';
		$product_index .= '<td>' . $product['name'] . '</td>';
		
		
		// to get page name and its id start
		global $connection;
		$query = "SELECT * FROM page_data WHERE id=" . $product['page_id'] . " LIMIT 1";
		$page_data = mysql_query($query, $connection);
		confirm_query($page_data);
		
		while($page = mysql_fetch_array($page_data)){
			$product_index .= '<td>' . $page['page_name'] . '</td>'; 
			$pg_id = $page['id'];
		}
		// get page name from id end
		
		
		$product_index .= '<td>' . $product['position'] . '</td>';
		$product_index .= '<td>';
		
		if($product['visible'] == 1){
			$product_index .= $product['visible'] = 'Yes' ;
		}else{
			$product_index .= $product['visible'] = 'No' ;
		}
		
		$product_index .= '<td>$' . $product['price'] . '</td>';
		$product_index .= '</td>';
		$product_index .= '<td><a href="'. site_options('link') .'admin/edit_page.php?page='. urlencode($pg_id) .'">Edit </a>';
		
		$alert = "'Are you sure you want to delete this page?'";
		
		$product_index .= '/&nbsp;<a href="'. site_options('link') .'admin/delete_page.php?product='. urlencode($product['id']) .'" onclick="return confirm('.$alert.');">Delete</a></td>';
		$product_index .= '</tr>';
					
	}
	$product_index .= '</table>' . $pagination['index'];
	
	return $product_index;
}


?>