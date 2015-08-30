<?php 
	require_once('../includes/admin_header.php'); 
	require_once('includes/admin_functions.php');
?>
	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
				<h3>Product Settings</h3>
				
					<?php 
					
						if(isset($_GET['updated'])){
							echo '<p class="alert alert-success">Product updated Successfully.</p>';
						}
						elseif(isset($_GET['added'])){
							echo '<p class="alert alert-success">Product added Successfully.</p>';
						}
						elseif(isset($_GET['success'])){
							echo '<p class="alert alert-success">Product deleted Successfully.</p>';
						}
						
						echo admin_products_index();
					?>
				
			<!--<a class="btn btn-success" href="<?php echo site_options('link'); ?>admin/new_product.php">New Product</a>-->
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>