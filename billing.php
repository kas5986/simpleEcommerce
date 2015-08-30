<?php require_once('includes/header.php'); ?>	

<?php 

	/*if(!isset($_SESSION['cart'])){
		redirect_to('index.php');
	}*/

	if(isset($_GET['orderSubmited']) && $_GET['orderSubmited'] == 1){
		$message = '<p class="alert alert-success">Your order has been submitted successfully</p>';
	}else{
		$message = '';
	}


?>


	
	<div class="row">
				
			<?php include('theme/sidebar.php'); ?>
			
			<article class="col-lg-9">

			<?php if (!empty($message)) {echo $message;} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>				
			<?php if (empty($message) and isset($_SESSION['cart'])) { ?>
				<form class="form-horizontal" name="form1" method="post" onsubmit="return validate()">
					<input type="hidden" name="command" />
					<table class="table">
						<tr>
							<td colspan="2"><h1 align="center">Billing Info</h1></td>
						<tr>
						<tr>
							<td width="50%" align="center"><strong>Order Total Amount:</strong> </td>
							<td width="50%" align="left"><strong style="color: green;"> $<?php echo get_order_total();?></strong></td>
						<tr>
					</table>
				
					
				  <div class="form-group">
					<label for="name" class="col-sm-2 control-label">Your Name:</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="name" name="name" required="" value="<?php echo $_SESSION['user_name']; ?>">
					</div>
				  </div>					
					
				  <div class="form-group">
					<label for="address" class="col-sm-2 control-label">Address:</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="address" name="address" required="" value="<?php echo $_SESSION['user_address']; ?>">
					</div>
				  </div>					
					
				  <div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email:</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="email" name="email" required="" value="<?php echo $_SESSION['email']; ?>">
					</div>
				  </div>						
					
				  <div class="form-group">
					<label for="phone" class="col-sm-2 control-label">Phone:</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="phone" name="phone" required=""  value="<?php echo $_SESSION['user_phone']; ?>">
					</div>
				  </div>							
					
				  <div class="form-group">
					<label for="order_note" class="col-sm-2 control-label">Order Note:</label>
					<div class="col-sm-10">
					  <textarea style="resize: none;" class="form-control" name="order_note" id="order_note" rows="3"></textarea>
					</div>
				  </div>	
				  
					<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10"><input class="btn btn-primary" type="submit" value="Place Order" /></div>
					</div>
				</form>
			<?php } ?>
			</article>
	</div>
<?php require_once('includes/footer.php'); ?>
