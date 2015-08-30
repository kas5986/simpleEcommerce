<?php 

// Get users for admin	
function get_orders_for_admin($count = false){
	global $connection;
		
		if($count == true){
			$query = "SELECT COUNT(*) FROM orders ORDER BY id ASC";
		}else {
			$query = "SELECT * FROM orders ORDER BY id ASC";
		}
		
		$page_data = mysql_query($query, $connection);
		confirm_query($page_data);
	return $page_data;
}

function get_order_by_status($case){
	global $connection;
	switch($case){
		
		case "recieved":
			$query = "SELECT * FROM orders WHERE status = 1 ORDER BY id DESC";	
		break;	
		
		case "process":
			$query = "SELECT * FROM orders WHERE status = 2 ORDER BY id DESC";	
		break;	
		
		case "completed":
			$query = "SELECT * FROM orders WHERE status = 3 ORDER BY id DESC";	
		break;	
	
	}
	
	$page_data = mysql_query($query, $connection);
	confirm_query($page_data);
	return $page_data;	
	
}


function get_orderDetail_by_id($id){
 $query = "SELECT * FROM order_detail WHERE order_id =" .$id;
 $result = mysql_query($query);
 $catArray = array();
 while($row = mysql_fetch_array($result)){
  $cats['order_id']=$row['order_id'];
  $cats['product_id']=$row['product_id'];
  $cats['quantity']=$row['quantity'];
  $cats['note']=$row['note'];
  $cats['price']=$row['price'];
  array_push($catArray,$cats);
 }
 return $catArray;
}



// get order details by id
function get_order_by_id($order_id){

	global $connection;
	
		$query = "SELECT *";
		$query .= "	FROM orders";
		$query .= "	WHERE id=" . $order_id;
		$query .= " LIMIT 1";
		
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		
		if($order = mysql_fetch_array($result_set)){
			return $order;
		}else{
			return NULL;
		}

}




// admin subjects index
function admin_order_index(){
	
	$pagination = pagination(15,'orders');
		
	$subject_index = '<table class="table table-hover table-bordered">';
	$subject_index .= '<tr><th>Order #</th><th>Order by</th><th>Order Total</th><th>Status</th><th>Modification</th></tr>';
	
	while($subject = mysql_fetch_array($pagination['query'])){
	
		$subject_index .= '<tr>';
		
		$subject_index .= '<td>' . $subject['id'] . '</td>';
		
		// get user name by its id !
		$order_by = get_user_by_id($subject['user_id']);
		
		$subject_index .= '<td>' . $order_by['username'] . '</td>';
		
		$subject_index .= '<td style="color: green;">$'. $subject['order_total'] .'</td>';
		if($subject['status'] == 1){
			$subject_index .= '<td style="color: red;">Recieved</td>';
		}elseif ($subject['status'] == 2){
			$subject_index .= '<td style="color: orange;">Process</td>';
		}elseif ($subject['status'] == 3){
			$subject_index .= '<td style="color: green;">Completed</td>';
		}else{
			$subject_index .= '<td>No Status !</td>';
		}
		
		
		

		$subject_index .= '<td><a href="'. site_options('link') .'admin/edit_order.php?order='. $subject['id'] .'">Details </a>';
		$alert = "'Are you sure you want to delete this page?'";
		$subject_index .= '/&nbsp;<a href="'. site_options('link') .'admin/delete_order.php?order='. $subject['id'] .'" onclick="return confirm('.$alert.');">Delete</a></td>';
		
			
		
		$subject_index .= '</tr>';
					
	}
	$subject_index .= '</table>';
	

			$subject_index .= $pagination['index'];	


	return $subject_index;
}




?>