<?php 
require_once('../includes/admin_header.php');
require_once('includes/admin_functions.php');
confirm_logged_in();
 ?>
	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
				<h3>Welcome to ACP, <span><?php echo $_SESSION['username'];?></span></h3>
				<br /><br />
				
				<h4>New Order Recieved</h4>
				<?php 
					$recieved_orders = get_order_by_status('recieved');
					echo '<table class="table table-hover table-bordered">';
					echo '<tr><th>Order #</th><th>Order by</th><th>Order Total</th><th>Status</th><th>Modification</th></tr>';
					while($orders = mysql_fetch_array($recieved_orders)){
						
						echo '<tr>';
						
						
						echo '<td>' . $orders['id'] . '</td>';
						
						// get user name by its id !
						$order_by = get_user_by_id($orders['user_id']);
						
						echo '<td>' . $order_by['username'] . '</td>';
						
						echo '<td style="color: green;">$'. $orders['order_total'] .'</td>';
						
						echo '<td style="color: red;">Recieved</td>';

						echo '<td><a href="'. site_options('link') .'admin/edit_order.php?order='. $orders['id'] .'">Details </a>';
						
						echo '</tr>';
						
					}
					echo '</table>';
				?>
				
				<br /><br />
				
				<h4>Applications waiting approval</h4>
				
<?php				$inactive_users = get_user_by_status('inactive');
					$users_index = '<table class="table table-hover table-bordered">';
					$users_index .= '<tr><th>ID</th><th>Name</th><th>Activation</th><th>User type</th><th>Modification</th></tr>';
					
					while($users = mysql_fetch_array($inactive_users)){
					
						$users_index .= '<tr>';
						
						$users_index .= '<td>' . $users['id'] . '</td>';
						$users_index .= '<td>' . $users['username'] . '</td>';
						if($users['activation'] == 1){
							$users_index .= '<td>Yes</td>';
						}else{
							$users_index .= '<td>No</td>';
						}
						
						if($users['user_type'] == 1){
							$users_index .= '<td>Admin</td>';
						}elseif($users['user_type'] == 2){
							$users_index .= '<td>Customer</td>';
						}else{
							$users_index .= '<td>'. $users['user_type'] .'</td>';
						}		
						

						$users_index .= '<td><a href="'. site_options('link') .'admin/edit_user.php?user='. $users['id'] .'">Edit </a>';	
						
						$users_index .= '</tr>';
									
					}
					$users_index .= '</table>';				
					echo $users_index;
				
?>				
				
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>