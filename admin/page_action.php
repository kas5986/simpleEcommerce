<?php 

	require('../includes/connection.php');
	require('../includes/functions.php');

	// Form validation
	$errors = array();
	
	$required_fields = array('page_name','subject_id','page_position', 'page_visible', 'page_content');
	
	foreach($required_fields as $fieldname){		
		if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && $_POST[$fieldname] != 0)){
			$errors[] = $fieldname;
		}	
	}
	
	$fields_with_lengths = array('page_name' => 30);
	foreach($fields_with_lengths as $fieldname => $maxlength ) {
		if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { 
		$errors[] = $fieldname; 
		}
	}
	
	
	if(!empty($errors)){
		redirect_to("page_index.php?error=1");
	}
	
	$page_name = mysql_prep($_POST['page_name']);
	$subject_id = mysql_prep($_POST['subject_id']);
	$page_position = mysql_prep($_POST['page_position']);
	$page_visible = mysql_prep($_POST['page_visible']);
	$page_content = mysql_prep($_POST['page_content']);
	
	// for products
	if(isset($_POST['product_check'])){
		$product_visible = mysql_prep($_POST['product_visible']);
		$product_price = mysql_prep($_POST['product_price']);
		$product_name = mysql_prep($_POST['product_name']);
		$product_content = mysql_prep($_POST['product_content']);
		$product_image = mysql_prep($_POST['product_image']);
		$product_position = mysql_prep($_POST['product_position']);
	}
	
	if(isset($_POST['update'])){
		$update = mysql_prep($_POST['update']);
	}
	if(isset($_POST['add'])){
		$add = mysql_prep($_POST['add']);
	}
	if(isset($_POST['id'])){
	$id = mysql_prep($_POST['id']);
		if(isset($_POST['pro_id'])){
			$pro_id = mysql_prep($_POST['pro_id']);
		}
	}
	
	if(isset($update)){
		$query = "UPDATE page_data 
				SET subject_id = {$subject_id}, 
				position = {$page_position}, 
				page_name = '{$page_name}',
				page_value = '{$page_content}',
				visible = {$page_visible}
				 WHERE id={$id}";
	}
	elseif(isset($add)){
		$query = "INSERT INTO page_data (subject_id, position, page_name, page_value, visible)
				VALUES ({$subject_id},{$page_position},'{$page_name}','{$page_content}',{$page_visible})";
	}
	else{
		// do something
	}
	
	if($overall_result_set = mysql_query($query, $connection)){
		
		if(isset($update)){
			if(isset($_POST['product_check'])){

				// for product image file upload
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $_FILES["picture_image"]["name"]);	
				$extension = end($temp);

				if ((($_FILES["picture_image"]["type"] == "image/gif")
				|| ($_FILES["picture_image"]["type"] == "image/jpeg")
				|| ($_FILES["picture_image"]["type"] == "image/jpg")
				|| ($_FILES["picture_image"]["type"] == "image/pjpeg")
				|| ($_FILES["picture_image"]["type"] == "image/x-png")
				|| ($_FILES["picture_image"]["type"] == "image/png"))
				&& ($_FILES["picture_image"]["size"] <= 1024*1024*5)
				&& in_array($extension, $allowedExts)){
					
					if ($_FILES["picture_image"]["error"] > 0){
						//handle if file have errors
						echo "Return Code: " . $_FILES["picture_image"]["error"] . "<br>";
						//redirect_to("/w-sell");
						exit;
					}else{

						if (file_exists("../images/products/" . $_FILES["picture_image"]["name"])){
						  $product_image = "images/products/" . $_FILES["picture_image"]["name"];
						}else{
						  $_FILES["picture_image"]["name"] = $product_name.time();
						  $_FILES["picture_image"]["name"] = sha1($_FILES["picture_image"]["name"]). '.' .$extension;
						  move_uploaded_file($_FILES["picture_image"]["tmp_name"], "../images/products/" . $_FILES["picture_image"]["name"]);
						  $product_image = "images/products/" . $_FILES["picture_image"]["name"];
						}
					}	
				
				}else{
				
					if($_FILES["picture_image"]["size"] >= 1024*1024*5){
						echo "more than 500 kb !";
						exit;
					}
					// handle if no file found to upload !
					$product_image = mysql_prep($_POST['product_image']);
					//echo "invalid file";
				}				
			
				// get id for the page inserted above
				$query_getID = "SELECT * 
							FROM page_data 
							WHERE position=" . $page_position . " 
							AND page_name='" . $page_name .  "' 
							AND subject_id=" . $subject_id . " 
							LIMIT 1";
				
				$get_id = mysql_query($query_getID, $connection);
				
				
				while($pro_page_id = mysql_fetch_array($get_id)){
					$set_ID = $pro_page_id['id'];
				}
				if($pro_id != NULL){				
					$query_pro = "UPDATE products 
								SET page_id ={$set_ID},
								subject_id = '{$subject_id}', 
								picture = '{$product_image}', 
								price = {$product_price}, 
								name = '{$product_name}', 
								description = '{$product_content}', 
								visible = {$product_visible}, 
								position = {$product_position} 
								WHERE id={$pro_id}";
				}else{
					$query_pro = "INSERT INTO products (page_id, picture, price, name, description, visible, position)
					VALUES ({$set_ID},'{$product_image}',{$product_price},'{$product_name}','{$product_content}',{$product_visible},{$product_position})";
				}
				
				
					if($product_result_set = mysql_query($query_pro, $connection)){
						redirect_to("page_index.php?updated=1");
					}
					else{
						echo "failed: " . $query_pro;
					}
			}else{
				redirect_to("page_index.php?updated=1");
			}		
		
		}
		
		// result for adding new subject and/or product
		if(isset($add)){
			
			if(isset($_POST['product_check'])){
			
			
				// for product image file upload
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $_FILES["picture_image"]["name"]);	
				$extension = end($temp);

				if ((($_FILES["picture_image"]["type"] == "image/gif")
				|| ($_FILES["picture_image"]["type"] == "image/jpeg")
				|| ($_FILES["picture_image"]["type"] == "image/jpg")
				|| ($_FILES["picture_image"]["type"] == "image/pjpeg")
				|| ($_FILES["picture_image"]["type"] == "image/x-png")
				|| ($_FILES["picture_image"]["type"] == "image/png"))
				&& ($_FILES["picture_image"]["size"] <= 1024*500)
				&& in_array($extension, $allowedExts)){
					
					if ($_FILES["picture_image"]["error"] > 0){
						//handle if file have errors
						echo "Return Code: " . $_FILES["picture_image"]["error"] . "<br>";
						//redirect_to("/w-sell");
						exit;
					}else{

						if (file_exists("../images/products/" . $_FILES["picture_image"]["name"])){
						  $product_image = "images/products/" . $_FILES["picture_image"]["name"];
						}else{
						  $_FILES["picture_image"]["name"] = sha1($_FILES["picture_image"]["name"]). '.' .$extension;
						  move_uploaded_file($_FILES["picture_image"]["tmp_name"], "../images/products/" . $_FILES["picture_image"]["name"]);
						  $product_image = "images/products/" . $_FILES["picture_image"]["name"];
						}
					}	
				
				}else{
				
					if($_FILES["picture_image"]["size"] >= 1024*500){
						echo "more than 500 kb !";
						exit;
					}
					// handle if no file found to upload !
					$product_image = mysql_prep($_POST['product_image']);
					//echo "invalid file";
				}			

				// get id for the page inserted above
				$query_getID = "SELECT * 
							FROM page_data 
							WHERE position=" . $page_position . " 
							AND page_name='" . $page_name .  "' 
							AND subject_id=" . $subject_id . " 
							LIMIT 1";
				
				$get_id = mysql_query($query_getID, $connection);
				
				
				while($pro_page_id = mysql_fetch_array($get_id)){
					$set_ID = $pro_page_id['id'];
				}
				
				$query_pro = "INSERT INTO products (page_id, subject_id, picture, price, name, description, visible, position)
				VALUES ({$set_ID}, {$subject_id},'{$product_image}',{$product_price},'{$product_name}','{$product_content}',{$product_visible},{$product_position})";				
				
					if($product_result_set = mysql_query($query_pro, $connection)){
						redirect_to("page_index.php?added=1");
					}
					else{
						
						$query_revert = "DELETE FROM page_data WHERE position=" . $page_position ;
						if($revert_result_set = mysql_query($query_revert, $connection)){
							echo "page removed successfully !";
						}
						echo "failed: " . $query_pro;
					}
			}else{
				redirect_to("page_index.php?added=1");
			}
		}
		exit;
	}else{
		echo "failed: " . $query;
	}
	


mysql_close($connection);

?>