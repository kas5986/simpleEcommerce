<?php require_once('includes/header.php'); ?>
<?php require_once('admin/includes/pagination.php'); ?>
<!-- for add to cart -->
<form name="form1">
	<input type="hidden" name="productid" />
    <input type="hidden" name="command" />
	<input type="hidden" name="productqty" />
	<input type="hidden" name="productnote" />
</form> 
		<div class="row">
		
			<?php include('theme/sidebar.php'); ?>
			
			
			<article class="col-lg-9">

				<?php 
					if ($sel_page || $sel_subject) {
						
						if(!empty($sel_subject['id']) || !empty($sel_page['id'])){
							
							if(!empty($sel_page['id'])){
								include('theme/product_page.php');
							} else {
								include('theme/subject_page.php');
							}
							
						}
						
					}else{ 
						include('theme/home.php'); 
					}
				
				?>

			</article>
		
	
	
		</div>
		
<?php require_once('includes/footer.php'); ?>