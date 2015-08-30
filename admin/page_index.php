<?php 
	require_once('../includes/admin_header.php'); 
	require_once('includes/admin_functions.php');
?>
	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
				<h3>Page Settings</h3>
				
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
						
						echo admin_page_index();
					?>
				
			<div class="row"><a class="btn btn-success" href="<?php echo site_options('link'); ?>admin/new_page.php">New page</a></div>
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>