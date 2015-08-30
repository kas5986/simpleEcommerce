<?php require_once('../includes/admin_header.php'); ?>
	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
			
				<h3>Edit : <?php echo $sel_subject['name']; ?></h3>
				<form id="options" class="form-horizontal" action="subject_action.php" role="form" method="post" enctype="multipart/form-data" onsubmit="return postSubject()">
					<input type="hidden" name="id" value="<?php echo $sel_subject['id']; ?>" />
				  <div class="form-group">
					<label for="subject_name" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="subject_name" value="<?php echo $sel_subject['name']; ?>" name="subject_name" placeholder="Subject Name">
					</div>
				  </div>
				  <div class="form-group">
					<label for="subject_nav" class="col-sm-2 control-label">Navigation</label>
					<div class="col-sm-10">
					  <input type="radio" class="radio-inline" id="subject_nav" name="subject_nav" value="1"
						<?php if($sel_subject['nav_id'] == 1 ){ echo 'checked="checked"';} ?>>
					  Sidebar Subject &nbsp;
					  <input type="radio" class="radio-inline" id="subject_nav" name="subject_nav" value="2"
						<?php if($sel_subject['nav_id'] == 2 ){ echo 'checked="checked"';} ?>>
					  Top Navigation Subject &nbsp;
					</div>
				  </div>
				  <div class="form-group">
					<label for="subject_position" class="col-sm-2 control-label">Subject Position</label>
					<div class="col-sm-10">
					  
					<select class="form-control" name="subject_position" id="subject_position">
						<?php
							$subject_set = get_main_subjects();
							
							
							$subject_count = mysql_num_rows($subject_set);
							// $subject_count + 1 b/c we are adding a subject
							echo "<option></option>";
							for($count=1; $count <= $subject_count+1; $count++) {
								
								echo "<option value=\"{$count}\"";
								
								if($sel_subject['position'] == $count ){
									echo " selected=\"selected\"";
								}
								
								echo ">{$count}</option>";
							}
						?>
					</select>
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
								echo "<option value=\"{$subject_id['id']}\"";
									if($sel_subject['parent_id'] == $subject_id['id']){
										echo ' selected="selected"';
									}
								echo ">{$subject_id['name']}</option>";
								}
							}
						?>
					</select>
					</div>
					
				  </div>
				  
				  <div class="form-group">
					<label for="subject_visible" class="col-sm-2 control-label">Visible</label>
					<div class="col-sm-10">
					  <input type="radio" class="radio-inline" id="subject_visible" name="subject_visible" value="0"
					  <?php if($sel_subject['visible'] == 0 ){ echo 'checked="checked"';} ?>> No &nbsp;
					  <input type="radio" class="radio-inline" id="subject_visible" name="subject_visible" value="1"
					  <?php if($sel_subject['visible'] == 1 ){ echo 'checked="checked"';} ?>>	
					  Yes &nbsp;
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="subject_content" class="col-sm-2 control-label">Subject Content</label>
					<div class="col-sm-10">
					  <textarea class="form-control" style="height: 500px;" id="subject_content" name="subject_content"><?php echo $sel_subject['content']; ?></textarea>
					</div>
				  </div>
				  
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" name="update" class="btn btn-default">Update Subject</button>
				  <a class="btn btn-danger" href="<?php echo site_options('link'); ?>admin/subject_index.php">cancel</a>
					</div>
				  </div>
				  
				</form>
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>