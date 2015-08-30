<?php
	require('../includes/connection.php');
	require('../includes/functions.php');
	require('includes/admin_functions.php');
	// make sure the id sent is an integer
	/*if (intval($_GET['page']) == 0 || intval($_GET['product']) == 0) {
		redirect_to('index.php');
	}*/
	
	// delete from pages page !
	if(isset($_GET['page'])){
		$id = mysql_prep($_GET['page']);
		
			if ($page = get_page_by_id($id)) {
				$query = "DELETE FROM page_data WHERE id = {$page['id']} LIMIT 1";

				$result = mysql_query ($query);
				if (mysql_affected_rows() == true) {
					$query_pro = "DELETE FROM products WHERE page_id = {$page['id']}";
					$run = mysql_query($query_pro);
					if (mysql_affected_rows() == true) {	
					// Successfully deleted
						redirect_to("page_index.php?deleted=2");
					}
					redirect_to("page_index.php?deleted=1");
				} else {
					// Deletion failed
					echo "<p>Page deletion failed.</p>";
					echo "<p>" . mysql_error() . "</p>";
					echo "<a href=\"index.php\">Return to Admin</a>";
				}
			} else {
				redirect_to('index.php');
			}			
	}
	
	// delete from products index page !
	if(isset($_GET['product'])){
		
			$p_id = mysql_prep($_GET['product']);	
			
			if ($product = get_product_by_id(NULL,$p_id)) {
				$pro_page_id = $product['page_id'];
				$query = "DELETE FROM products WHERE id = {$product['id']} LIMIT 1";

				$result = mysql_query ($query);
				if (mysql_affected_rows() == true) {
					$query_page = "DELETE FROM page_data WHERE id = {$pro_page_id}";
					$run = mysql_query($query_page);
					if (mysql_affected_rows() == true) {	
					// Successfully deleted
						redirect_to("page_index.php?deleted=2");
					}
					redirect_to("page_index.php?deleted=1");
				} else {
					// Deletion failed
					echo "<p>Page deletion failed.</p>";
					echo "<p>" . mysql_error() . "</p>";
					echo "<a href=\"index.php\">Return to Admin</a>";
				}
			} else {
				redirect_to('index.php');
			}
			
	}

?>
<?php mysql_close($connection); ?>
