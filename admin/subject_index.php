<?php 
require_once('../includes/admin_header.php'); 
require_once('includes/admin_functions.php');
?>
	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
			<div class="row">	
				
				<h3>Subject Settings</h3>
				
					<?php 
					
						if(isset($_GET['updated'])){
							echo '<p class="alert alert-success">Subject updated Successfully.</p>';
						}
						elseif(isset($_GET['added'])){
							echo '<p class="alert alert-success">Subject added Successfully.</p>';
						}
						elseif(isset($_GET['deleted'])){
							echo '<p class="alert alert-info">Subject deleted Successfully.</p>';
						}
						
						echo admin_subject_index();
					?>

			</div>
			<div class="row">
			<a class="btn btn-success" href="<?php echo site_options('link'); ?>admin/new_subject.php">New Subjects</a>
			</div>
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>