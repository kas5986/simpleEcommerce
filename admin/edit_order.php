<?php 
	require_once('../includes/admin_header.php'); 
	require_once('includes/admin_functions.php');
	
	if (intval($_GET['order']) == 0) {
		redirect_to('order_index.php');
	}else{
		$sel_order = get_order_by_id($_GET['order']);
		$sel_orderDetail = get_orderDetail_by_id($_GET['order']);
		$sel_orderUser = get_user_by_id($sel_order['user_id']);
		if(isset($_GET['success'])){
		$message = '<p class="alert alert-success">Order updated successfully.</p>';
		}else{
		$message = '';
		}
	}
	
	if (isset($_POST['update'])) {
		
		$status = trim(mysql_prep($_POST['status']));
		$query = "UPDATE orders SET status ={$status} WHERE id = {$_GET['order']}";
		
		$result = mysql_query($query, $connection);			
		
		if ($result) {
			$message = '<p class="alert alert-success">Order updated successfully.</p>';
			redirect_to('edit_order.php?success=1&order='.$_GET['order']);
		} else {
			$message = '<p class="alert alert-warning">The Order could not be updated.</p>';
			$message .= "<br />" . mysql_error();
		}		
	
		

	}else{
		//do something !
	}
	
	
	
?>
	
		<div class="row">
		
			<?php include('admin_sidebar.php'); 
			
			?>

			<article class="col-lg-9">
				

				
			<?php if (!empty($message)) {echo $message;} ?>
				
				
				<div class="panel panel-default">
				  <!-- Default panel contents -->
				  <div class="panel-heading"> <strong>Order # <?php echo $sel_order['id']; ?></strong> </div>
				  <div class="panel-body">
					<p class="alert alert-warning"><strong>Order Note:&nbsp;</strong><?php echo $sel_order['note']; ?></p>
					</div>
				  <!-- Table -->
						<table class="table">
						<tr>
							<td><strong>Order By :</strong> <?php echo $sel_orderUser['username']; ?></td>
							<td><strong>Date :</strong> <?php echo $sel_order['dated']; ?></td>
							
							<?php if($sel_order['status'] == 1){ ?>
								<td><span class="label label-danger"> <?php echo $sel_order['status'] = 'Recieved'; ?></span></td>
							<?php } elseif($sel_order['status'] == 2){ ?>
								<td><span class="label label-warning"> <?php echo $sel_order['status'] = 'Process'; ?></span></td>
							<?php } elseif($sel_order['status'] == 3){ ?>
								<td><span class="label label-success"> <?php echo $sel_order['status']  = 'Completed'; ?></span></td>
							<?php } ?>
							
						</tr>
						
						
						<tr>
							<td>Email:</td>
							<td colspan="2"><?php echo $sel_orderUser['email']?></td>
						</tr>
						<tr>
							<td>Name:</td>
							<td colspan="2"><?php echo $sel_orderUser['name']?></td>
						</tr>
						<tr>
							<td>Address:</td>
							<td colspan="2"><?php echo $sel_orderUser['address']?></td>
						</tr>
						
						</table>
					
						<table class="table">
						<tr>
							<th>Product ID</th>
							<th>Product Name</th>
							<th>Note</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Total</th>
						</tr>
						<?php foreach($sel_orderDetail as $row){ ?>
							<tr>
								<td><?php echo $row['product_id']; ?></td>
								<td><?php 
										$pro_name = get_product_by_id($row['product_id']);
										echo $pro_name['name']; 
								?></td>
								<td><?php echo $row['note']; ?></td>
								<td><?php echo $row['quantity']; ?></td>
								<td>$<?php echo $row['price']; ?></td>
								<td>$<?php echo $row['price'] * $row['quantity']; ?></td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="5">Sub-Total</td>
							<td><strong>$<?php echo $sel_order['order_total']; ?></strong></td>
						</tr>
						
						</table>
				  


				</div>
				
				<form id="options" class="form-horizontal" action="" role="form" method="post">
				<div class="form-group">
				<label class="col-sm-3 control-label" for="status">Action</label>
					
					<div class="col-sm-6">
						<select class="form-control" name="status">
							<option value="1">Recieved</option>
							<option value="2">Process</option>
							<option value="3">Completed</option>
						</select>				
					</div>	
					
					<div class="col-sm-3">
					<button type="submit" name="update" class="btn btn-success">Update Order</button>
					</div>
					
				</div>

				</form>
			</article>

		</div>

<?php require_once('../includes/footer.php'); ?>