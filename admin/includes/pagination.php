<?php 
include('product_functions.php');
include('page_functions.php');
include('subject_functions.php');
include('user_functions.php');
// this is for all pagination work !
function pagination($per_page, $case, $cat = 0){
// case 1 for subjects
// case 2 for pages
// case 3 for products
// case 4 for users
	if($per_page == 0){
		$per_page = 5;
	}
	$subject_index ='';
	$subj = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1;
	$start = ($subj - 1) * $per_page;	
	
	// this will return $query !
	switch ($case){
		
		case "subjects":
			$subject_set = get_subjects_for_admin(true);
			$query = mysql_query("SELECT * FROM page_subjects ORDER BY id DESC LIMIT $start,$per_page");	
		break;
		
		case "users":
			$subject_set = get_users_for_admin(true);
			$query = mysql_query("SELECT * FROM users ORDER BY id DESC LIMIT $start,$per_page");	
		break;			
		
		case "orders":
			$subject_set = get_orders_for_admin(true);
			$query = mysql_query("SELECT * FROM orders ORDER BY id DESC LIMIT $start,$per_page");	
		break;		
		
		case "pages":
			$subject_set = get_pages_for_admin(true);
			$query = mysql_query("SELECT * FROM page_data ORDER BY id DESC LIMIT $start,$per_page");	
		break;
		
		case "products":
			$subject_set = get_products_for_admin(true);
			$query = mysql_query("SELECT * FROM products ORDER BY id DESC LIMIT $start,$per_page");	
		break;
		
		case "cat_products":
			$subject_set = get_products_for_cat($cat);
			$query = mysql_query("SELECT * FROM products WHERE subject_id = $cat ORDER BY id DESC LIMIT $start,$per_page");	
		break;
		
		default:
			echo "No case selected for pagination !";
		break;

	}
	
	$subject_total = ceil(mysql_result($subject_set, 0) / $per_page);
	
		$category_link = '';
		
		if($cat > 0){
			$category_link = 'subject='.$cat.'&';
		}
	
	// return pagination !
	if ($subject_total >=2 && $subj <=$subject_total) {
		$subject_index .= '<ul class="pagination pagination-sm">';
		if(isset($_GET['pg']) && $_GET['pg'] > 1){
			$subject_index .= '<li><a href="?'.$category_link.'pg='.($_GET['pg'] -1) .'">&laquo;</a></li>';	
		}else{
			$subject_index .= '<li class="disabled"><a href="#">&laquo;</a></li>';
		}	
		  for ($x=1; $x<=$subject_total; $x++) {
			$subject_index .= ($x == $subj) ? '<li class="active"><a href="?'.$category_link.'pg='.$x.'">'.$x.'</a></li> ' : '<li><a href="?'.$category_link.'pg='.$x.'">'.$x.'</a></li> ';
		  }
	
		if(isset($_GET['pg']) && $_GET['pg'] < $subject_total){
			$subject_index .= '<li><a href="?'.$category_link.'pg='.($_GET['pg'] +1) .'">&raquo;</a></li>';
		}else{
			$subject_index .= '<li class="disabled"><a href="#">&raquo;</a></li>';
		}
		
		$subject_index .= '</ul>';
	}

	$value = array('query' => $query, 'index' => $subject_index);
	return $value;
}



?>