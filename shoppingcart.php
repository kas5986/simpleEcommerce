<?php require_once('includes/header.php'); ?>
		<div class="row">
			
			<?php include('theme/sidebar.php'); ?>
			
			
			<article class="col-lg-9">
				<form name="form1" method="post">
				<input type="hidden" name="pid" />
				<input type="hidden" name="command" />

				<!-- rules for sending orders -->
					<div class="modal fade" id="help">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Order Rules !</h4>
						  </div>
						  <div class="modal-body">
							<p>This is details for sending us order !&hellip;</p>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
	
	
	
	<a class="btn btn-danger" data-toggle="modal" href="#help" >Help!</a>					
					
						<h3>Your Shopping Cart</h3>
					<input class="btn buy expand" type="button" value="Continue Shopping" onclick="window.location='content.php'" />
					<br />
						<?php 
							if(isset($msg)){ 
								echo $msg; 
							}
							
							echo shopping_cart();
						?>
						
					
				</form>

			</article>
		
	
	
		</div>
<?php require_once('includes/footer.php'); ?>