<?php 
	
	// check if subject get set
	if(isset($_GET['subject'])){
		$sel_subject = get_subject_by_id($_GET['subject']);
	}else{
		$sel_subject = NULL;
	}
	
	// check if subject get set
	if(isset($_GET['child'])){
		$sel_subject_child = get_subject_by_id($_GET['child']);
	}else{
		$sel_subject_child = NULL;
	}	
	
	
	// check if page get set	
	if(isset($_GET['page'])){
		$sel_page = get_page_by_id($_GET['page']);
		$sel_product = get_product_by_id($_GET['page'],'');
	}else{
		$sel_page = NULL;
		$sel_product = NULL;
	}

	
	if(isset($_REQUEST['command']) || isset($_REQUEST['pid']) || isset($_REQUEST['productid'])){
		
		// for add to cart 
		if($_REQUEST['command']=='add' && $_REQUEST['productid']>0){
			$pid=$_REQUEST['productid'];
			$p_qty=$_REQUEST['productqty'];
			$p_note=$_REQUEST['productnote'];
			addtocart($pid,$p_qty,$p_note);
			header("location:shoppingcart.php?qty=".$p_qty);
			exit();
		}
	
		if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){// delete from cart
			remove_product($_REQUEST['pid']);
		}
		else if($_REQUEST['command']=='clear'){ // clear shopping cart 
			unset($_SESSION['cart']);
		}
		else if($_REQUEST['command']=='updatecart'){ // update shopping cart
			$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				$pid=$_SESSION['cart'][$i]['productid'];
				$q=intval($_REQUEST['product'.$pid]);
				$p_note=$_REQUEST['product_note'.$pid];
				if($q>0 && $q<=999){
					$_SESSION['cart'][$i]['qty']=$q;
					$_SESSION['cart'][$i]['productnote']=$p_note;
				}
				else{
					$msg='<p class="alert alert-success">Some proudcts not updated!, quantity must be a number between 1 and 999</p>';
				}
			}
		}
		
		
		if($_REQUEST['command']=='update'){
			$name=$_REQUEST['name'];
			$user_id=$_SESSION['user_id'];
			$email=$_REQUEST['email'];
			$address=$_REQUEST['address'];
			$phone=$_REQUEST['phone'];
			$order_note=$_REQUEST['order_note'];
			
			$result=mysql_query("insert into customers values('','$user_id','$name','$email','$address','$phone')");
			$customerid=mysql_insert_id();
			$dated=date('Y-m-d H:i:s');
			$result=mysql_query("insert into orders values('','$dated','$user_id','1','". get_order_total() ."','$order_note')");
			confirm_query($result);

			$orderid=mysql_insert_id();

				// send email after user activation !
				$mail_subject = "Your Order at: ". site_options('title');
				$email_message = 'Hello! Your order is been recieved, order ID is #'.$orderid.' , Thanks.';
				$from = site_options('email');
				$mail_headers = "From:" . $from;
				mail($_SESSION['email'],$mail_subject,$email_message,$mail_headers);


				// send email after user activation to admin !
				$mail_subject = "New order from: ". $_SESSION['user_name'];
				$email_message = 'New order recieved, order ID is #'.$orderid.' , Thanks.';
				$from = $_SESSION['email'];
				$mail_headers = "From:" . $from;
				mail(site_options('email'),$mail_subject,$email_message,$mail_headers);

				
			$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				$pid=$_SESSION['cart'][$i]['productid'];
				$p_note=$_SESSION['cart'][$i]['productnote'];
				$q=$_SESSION['cart'][$i]['qty'];
				$price=get_price($pid);
				$order_details = mysql_query("insert into order_detail (order_id, product_id, quantity, price, note) values ($orderid,$pid,$q,$price,'{$p_note}')");
				confirm_query($order_details);
			}
			if(isset($_SESSION['cart'])){
					unset($_SESSION['cart']);
			}
			redirect_to('billing.php?orderSubmited=1');
		}	

	}
	



?>