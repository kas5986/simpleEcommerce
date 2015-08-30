<?php 
require_once('../includes/admin_header.php');
require_once('includes/admin_functions.php');
 ?>
	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
				<form id="options" class="form-horizontal" action="subject_action.php" role="form" method="post" enctype="multipart/form-data" onsubmit="return postSubject()">
					<?php 
						$subject_set = get_subjects_for_admin();
						$subject_count = mysql_num_rows($subject_set) + 1;
					?>
					<input type="hidden"  name="subject_position" id="subject_position" value="<?php echo $subject_count; ?>" />
				  
				  <div class="form-group">
					<label for="subject_name" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Subject Name">
					</div>
				  </div>
				  <div class="form-group">
					<label for="subject_nav" class="col-sm-2 control-label">Navigation</label>
					<div class="col-sm-5">
					  <input type="radio" class="radio-inline" id="subject_nav" name="subject_nav" value="1"> Sidebar Category &nbsp;
					  <input type="radio" class="radio-inline" id="subject_nav" name="subject_nav" value="2"> Top Navigation &nbsp;
					</div>
					
					<label for="subject_visible" class="col-sm-2 control-label">Visible</label>
					<div class="col-sm-3">
					  <input type="radio" class="radio-inline" id="subject_visible" name="subject_visible" value="0"> No &nbsp;
					  <input type="radio" class="radio-inline" id="subject_visible" name="subject_visible" value="1"> Yes &nbsp;
					</div>				  
				  
				  </div>
				  
				  <div class="form-group">

					<label for="subject_parent" class="col-sm-2 control-label">Parent</label>
					<div class="col-sm-10">
					  
					<select class="form-control" name="subject_parent" id="subject_parent">
						<?php
							$subject_set = get_main_subjects('parent');
							
							echo '<option value="0">No Parent</option>';
							while($subject_id = mysql_fetch_array($subject_set)) {
								
								if($subject_id['nav_id'] == 1){
								echo "<option value=\"{$subject_id['id']}\">{$subject_id['name']}</option>";
								}
							}
						?>
					</select>
					</div>
					
				  </div>
				  
				  <div class="form-group">
					<label for="subject_content" class="col-sm-2 control-label">Subject Content</label>
					<div class="col-sm-10">
					  <textarea class="form-control" style="height: 500px;" id="subject_content" name="subject_content"></textarea>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" name="add" class="btn btn-default">Add Subject</button>
				  <a class="btn btn-danger" href="<?php echo site_options('link'); ?>admin/subject_index.php">cancel</a>
					</div>
				  </div>
				  
				</form>
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>