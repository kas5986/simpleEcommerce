<?php 
	require_once('../includes/admin_header.php'); 
	require_once('includes/admin_functions.php');
?>
	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
			<h3>Edit : <?php echo $sel_page['page_name']; ?></h3>
				<form id="options" class="form-horizontal" action="page_action.php" role="form" method="post" enctype="multipart/form-data" onsubmit="return postPage()">
					<input type="hidden" name="id" value="<?php echo $sel_page['id']; ?>" />
					<input type="hidden" name="pro_id" value="<?php echo $sel_product['id']; ?>" />
				  <div class="form-group">
					<label for="page_name" class="col-sm-2 control-label">Page Title</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="page_name" name="page_name"  value="<?php echo $sel_page['page_name']; ?>" placeholder="Page Title">
					</div>
				  </div>
				  <div class="form-group">
					<label for="subject_id" class="col-sm-2 control-label">Subject Position</label>
					<div class="col-sm-5">
					  
					<select class="form-control" name="subject_id" id="subject_id">
						<?php
							$subject_set = get_main_subjects();
							
							echo "<option></option>";
							while($subject_id = mysql_fetch_array($subject_set)) {
								echo "<option value=\"{$subject_id['id']}\"";
								
								if($sel_page['subject_id'] == $subject_id['id'] ){
									echo " selected=\"selected\"";
								}
								echo ">{$subject_id['name']}</option>";
							}
						?>
					</select>
					</div>
					<label for="page_position" class="col-sm-2 control-label">Page Position</label>
					<div class="col-sm-3">
					  
					<select class="form-control" name="page_position" id="page_position">
						<?php
							$page_set = get_pages_for_admin();
							
							
							$page_count = mysql_num_rows($page_set);
							// $subject_count + 1 b/c we are adding a subject
							echo "<option></option>";
							for($count=1; $count <= $page_count+1; $count++) {
								echo "<option value=\"{$count}\"";
								
								if($sel_page['position'] == $count ){
									echo " selected=\"selected\"";
								}
								
								echo ">{$count}</option>";
							}
						?>
					</select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="page_visible" class="col-sm-2 control-label">Visible</label>
					<div class="col-sm-10">
					  <input type="radio" class="radio-inline" id="page_visible" name="page_visible" value="0"
					  <?php if($sel_page['visible'] == 0 ){ echo 'checked="checked"';} ?>> No &nbsp;
					  <input type="radio" class="radio-inline" id="page_visible" name="page_visible" value="1"
					  <?php if($sel_page['visible'] == 1 ){ echo 'checked="checked"';} ?>> Yes &nbsp;
					</div>
				  </div>
				  <div class="form-group">
					<label for="page_content" class="col-sm-2 control-label">Page Content</label>
					<div class="col-sm-10">
					  <textarea class="form-control" style="height: 200px;" id="page_content" name="page_content"><?php echo $sel_page['page_value']; ?></textarea>
					</div>
				  </div>

				  <!-- display add new product start -->
				  <div class="form-group">
					<label for="product_check" class="col-sm-2 control-label">Product</label>
					<div class="col-sm-1">
					  <input type="checkbox" class="radio" id="product_check" name="product_check" value="1" 
					  <?php if(isset($sel_product['id'])){ echo 'checked="checked"';} ?> onclick="exefunction()" />
					</div>
					<div id="product_visible_title">
					<label for="product_visible" class="col-sm-2 control-label">Visible</label>
					<div class="col-sm-2">
					  <input type="radio" class="radio-inline" id="product_visible" name="product_visible" value="0"
					  <?php if($sel_product['visible'] == 0 ){ echo 'checked="checked"';} ?>> No &nbsp;
					  <input type="radio" class="radio-inline" id="product_visible" name="product_visible" value="1"
					  <?php if($sel_product['visible'] == 1 ){ echo 'checked="checked"';} ?>> Yes &nbsp;
					</div>
					<label for="product_price" class="col-sm-2 control-label">Price</label>
					<div class="col-sm-3 input-group">
					  <input type="text" class="form-control" value="<?php echo $sel_product['price']; ?>" id="product_price" name="product_price" placeholder="Product Price">
					  <span class="input-group-addon">.00</span>
					</div>					
					</div>
				  </div>
				  
				  <div class="form-group" id="product_name_title">
					<label for="product_name" class="col-sm-2 control-label">Product Name</label>
					<div class="col-sm-5">
					  <input type="text" class="form-control" value="<?php echo $sel_product['name']; ?>" id="product_name" name="product_name" placeholder="Product Name">
					</div>
					<label for="product_position" class="col-sm-2 control-label">Product Position</label>
					<div class="col-sm-3">
					  
					<select class="form-control" name="product_position" id="product_position">
						<?php
							$product_set = get_products_for_admin();
							
							
							$products_count = mysql_num_rows($product_set);
							// $subject_count + 1 b/c we are adding a subject
							echo "<option></option>";
							for($count=1; $count <= $products_count+1; $count++) {
								echo "<option value=\"{$count}\"";
								
								if($sel_product['position'] == $count ){
									echo " selected=\"selected\"";
								}
								
								echo ">{$count}</option>";
							}
						?>
					</select>
					</div>				  
				  </div>				  
				  
				  <div class="form-group" id="product_content_title">
					<label for="product_content" class="col-sm-2 control-label">Product Description</label>
					<div class="col-sm-10">
					  <textarea class="form-control" style="height: 200px;" id="product_content" name="product_content"><?php echo $sel_product['description']; ?></textarea>
					</div>
				  </div>

				  <div class="form-group" id="product_image_title">
					<label for="picture_image" class="col-sm-2 control-label">Product Image</label>
					<div class="col-sm-10">
					  <input type="file" name="picture_image" id="picture_image">
					  <input type="hidden" class="form-control" id="product_image" name="product_image" value="<?php echo $sel_product['picture']; ?>" placeholder="Product image">
					  <?php if(!empty($sel_product['picture'])){ ?>
					  <p class="help-block"><img height="150" width="150" class="thumbnail" src="<?php echo site_options('link').$sel_product['picture']; ?>"/></p>
					  <?php } else { echo '<p class="help-block">No image added</p>';} ?>
					</div>
				  </div>				  
				  <!-- display add new product end -->
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" name="update" class="btn btn-default">Update Page</button>
				  <a class="btn btn-danger" href="<?php echo site_options('link'); ?>admin/page_index.php">cancel</a>
					</div>
				  </div>
				  
				</form>
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>