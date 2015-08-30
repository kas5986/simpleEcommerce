<?php 
	require_once('../includes/admin_header.php'); 
	require_once('includes/admin_functions.php');
?>
	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
				<h3>Orders</h3>
				
					<?php 
					
						if(isset($_GET['updated'])){
							echo '<p class="alert alert-success">Page updated Successfully.</p>';
						}
						elseif(isset($_GET['added'])){
							echo '<p class="alert alert-success">Page added Successfully.</p>';
						}
						elseif(isset($_GET['deleted'])){
							echo '<p class="alert alert-success">Page deleted Successfully.</p>';
						}
						elseif(isset($_GET['error'])){
							echo '<p class="alert alert-danger">There is an error .</p>';
						}
						
						echo admin_order_index();
						
					?>
				
			
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>