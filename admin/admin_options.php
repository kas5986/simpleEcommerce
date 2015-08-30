<?php require_once('../includes/admin_header.php'); ?>

<!-- $dirs = array_filter(glob('theme/*'), 'is_dir'); -->

	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
				
					<?php 
					
						if(isset($_GET['success'])){
							echo '<p class="alert alert-success">Settings Updated Successfully.</p>';
						}
					
					?>
			<h3>Website Settings</h3>

				<?php 
				$query = "SELECT * FROM site_options WHERE id= 1 LIMIT 1";
				$result_set = mysql_query($query, $connection);
				confirm_query($result_set);
				$settings = mysql_fetch_array($result_set);
				
				?>
							
				
				<form id="options" class="form-horizontal" action="options_action.php" role="form" method="post" enctype="multipart/form-data" onsubmit="return postWelcome()">
					<input type="hidden" name="id" value="<?php echo $settings['id']; ?>" />
				  <div class="form-group">
					<label for="site_title" class="col-sm-2 control-label">Website title</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" value="<?php echo $settings['title']; ?>" id="site_title" name="site_title" placeholder="Website title">
					</div>
				  </div>
				  <div class="form-group">
					<label for="site_url" class="col-sm-2 control-label">Site URL</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" value="<?php echo $settings['link']; ?>" id="site_url" name="site_url" placeholder="Site URL">
					</div>
				  </div>
				  <div class="form-group">
					<label for="site_email" class="col-sm-2 control-label">Site Email</label>
					<div class="col-sm-10">
					  <input type="email" class="form-control" value="<?php echo $settings['email']; ?>" id="site_email" name="site_email" placeholder="Site Email">
					</div>
				  </div>
				  <div class="form-group">
					<label for="site_description" class="col-sm-2 control-label">Site Description</label>
					<div class="col-sm-10">
					  <textarea class="form-control" id="site_description" name="site_description" placeholder="Site Description"><?php echo $settings['description']; ?></textarea>
					</div>
				  </div>
				  <div class="form-group">
					<label for="logo_file" class="col-sm-2 control-label">Site Logo</label>
					<div class="col-sm-10">
					  <input type="file" name="logo_file" id="logo_file">
					  <input type="hidden" class="form-control" value="<?php echo $settings['logo']; ?>" id="site_logo" name="site_logo" placeholder="Site logo">
					  <?php if(!empty($settings['logo'])){ ?>
					  <p class="help-block"><img class="thumbnail" src="<?php echo site_options('link').$settings['logo']; ?>"/></p>
					  <?php } else { echo '<p class="help-block">No logo added</p>';} ?>
					</div>
				  </div>
				  
				  <div class="form-group text-center">
					<h3>Home Page Settings</h3>
				  </div>
				  <div class="form-group">
					<label for="site_ppr" class="col-sm-2 control-label">Products Per Page</label>
					<div class="col-sm-10">
					 <input type="text" class="form-control" value="<?php echo $settings['new_products']; ?>" id="site_ppr" name="site_ppr" placeholder="Products Per Page">  
					</div>
				  </div>				  
				  
				  <div class="form-group">
					<label for="site_welcome" class="col-sm-2 control-label">Welcome page</label>
					<div class="col-sm-10">
					  <textarea class="form-control" style="height: 500px;" id="site_welcome" name="site_welcome"><?php echo $settings['welcome']; ?></textarea>
					</div>
				  </div>				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" class="btn btn-default">Update</button>
				  <a class="btn btn-danger" href="<?php echo site_options('link'); ?>admin/index.php">cancel</a>
					</div>
				  </div>
				</form>



			
			
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>