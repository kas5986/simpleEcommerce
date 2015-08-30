<?php

/*
	get_product_name($pid);
	get_price($pid);
	remove_product($pid);
	get_order_total();
	addtocart($pid,$q);
	product_exists($pid);
	shopping_cart();
	nav_shopping_cart();
*/
	function get_product_name($pid){
		global $connection;
		
			$query = "SELECT name FROM products WHERE id=" .$pid;
			$result = mysql_query($query, $connection);
			confirm_query($result);
			$row = mysql_fetch_array($result);
		
		return $row['name'];
	}
	
	function get_price($pid){
		global $connection;
			
			$query = "SELECT price FROM products WHERE id=" . $pid;
			$result = mysql_query($query, $connection);
			confirm_query($result);		
			$row = mysql_fetch_array($result);
		
		return $row['price'];
	}
	
	function remove_product($pid){
		$pid=intval($pid);
		
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				unset($_SESSION['cart'][$i]);
				break;
			}
		}
		$_SESSION['cart']=array_values($_SESSION['cart']);
	}
	
	function get_order_total(){
		$max=count($_SESSION['cart']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$p_note=$_SESSION['cart'][$i]['productnote'];
			$q=$_SESSION['cart'][$i]['qty'];
			$price=get_price($pid);
			$sum+=$price*$q;
		}
		return $sum;
	}
	
	function addtocart($pid, $q, $p_note){
		if($pid<1 or $q<1) return;
		
		if(is_array($_SESSION['cart'])){
			if(product_exists($pid)) return;
			$max=count($_SESSION['cart']);
			$_SESSION['cart'][$max]['productid']=$pid;
			$_SESSION['cart'][$max]['productnote']=$p_note;
			$_SESSION['cart'][$max]['qty']=$q;
		}
		else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['productid']=$pid;
			$_SESSION['cart'][0]['productnote']=$p_note;
			$_SESSION['cart'][0]['qty']=$q;
		}
	}
	
	function product_exists($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				$flag=1;
				break;
			}
		}
		return $flag;
	}

	// shopping cart 
	function shopping_cart(){
		
		$cart = '<table class="table table-hover table-bordered">';
			if(isset($_SESSION['cart'])){
				if(is_array($_SESSION['cart'])){
					
					$cart .= '<tr><th>Product ID</th><th>Product</th><th>Price</th><th>Qty</th><th>Amount</th><th>Options</th><th>Note</th></tr>';
					
					$max = count($_SESSION['cart']);
					
					for($i=0;$i<$max;$i++){
						$pid=$_SESSION['cart'][$i]['productid'];
						$p_note=$_SESSION['cart'][$i]['productnote'];
						$q=$_SESSION['cart'][$i]['qty'];
						$pname=get_product_name($pid);
						if($q==0) continue;
				
						$cart .= '<tr><td>' . $pid . '</td><td>' . $pname . '</td>';
						$cart .= '<td>&#36;' . get_price($pid) . '</td>';
						$cart .= '<td><button class="btn btn-default"  onclick="dec_qty('.$pid.')" type="button">-</button><input type="text" id="qty_pro_'.$pid.'" class="qty_pro" name="product' .  $pid. '" value="' . $q . '" maxlength="3" size="2" /><button type="button"  onclick="inc_qty('.$pid.')" class="btn btn-default">+</button></td>';                    
						$cart .= '<td>&#36;' . get_price($pid)*$q .'</td>';
						$cart .= '<td><a href="javascript:del(' . $pid. ')">Remove</a></td>';
						$cart .= '<td><input type="text" name="product_note' .  $pid. '" value="' . $p_note . '" /></td></tr>'; 
									
					}
				
					$cart .= '<tr><td><b>Order Total: &#36;' . get_order_total() .'</b></td><td colspan="5" align="right">';
					$cart .= '<div class="btn-group"><input type="button" class="btn btn-default" value="Clear Cart" onclick="clear_cart()"><input type="button" class="btn btn-default" value="Update Cart" onclick="update_cart()"><input type="button" class="btn buy expand" value="Place Order" onclick="window.location=\'billing.php\'"></div></td></tr>';
				
				}
			}	
			else{
			$cart .= '<tr><td>There are no items in your shopping cart!</td>';
			}
		
		$cart .= '</table>';
		
		return $cart;
	}
	
	// shopping cart 
	function nav_shopping_cart(){
		
		$cart = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Cart <b class="caret"></b></a><ul class="dropdown-menu">';
			if(isset($_SESSION['cart'])){
				if(is_array($_SESSION['cart'])){
					
					//$cart .= '<tr><th>Product ID</th><th>Product</th><th>Price</th><th>Qty</th><th>Amount</th><th>Options</th></tr>';
					
					$max = count($_SESSION['cart']);
					
					for($i=0;$i<$max;$i++){
						$pid=$_SESSION['cart'][$i]['productid'];
						$q=$_SESSION['cart'][$i]['qty'];
						$pname=get_product_name($pid);
						if($q==0) continue;
				
						$cart .= '<tr><td>' . $pid . '</td><td>' . $pname . '</td>';
						$cart .= '<td>&#36;' . get_price($pid) . '</td>';
						$cart .= '<td><input type="text" name="product' .  $pid. '" value="' . $q . '" maxlength="3" size="2" /></td>';                    
						$cart .= '<td>&#36;' . get_price($pid)*$q .'</td>';
						$cart .= '<td><a href="javascript:del(' . $pid. ')">Remove</a></td></tr>';
									
					}
				
					$cart .= '<tr><td><b>Order Total: &#36;' . get_order_total() .'</b></td><td colspan="5" align="right">';
					$cart .= '<div class="btn-group"><input type="button" class="btn btn-default" value="Clear Cart" onclick="clear_cart()"><input type="button" class="btn btn-default" value="Update Cart" onclick="update_cart()"><input type="button" class="btn btn-info" value="Place Order" onclick="window.location=\'billing.php\'"></div></td></tr>';
				
				}
			}	
			else{
			$cart .= '<li>There are no items in your shopping cart!</li>';
			}
		
		$cart .= '</ul></li>';
		
		return $cart;
	}	
	
	
	
?>