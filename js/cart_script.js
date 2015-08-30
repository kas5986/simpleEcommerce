// order form validation 	
	function validate(){
		var f=document.form1;
		if(f.name.value==''){
			alert('Your name is required');
			f.name.focus();
			return false;
		}
		f.command.value='update';
		f.submit();
	}


// add to cart function
	function addtocart(pid){
		document.form1.productid.value=pid;
		document.form1.productqty.value= $('#qty_pro_'+pid).val();
		document.form1.productnote.value= $('#pro_note_'+pid).val();
		document.form1.command.value='add';
		document.form1.submit();
	}
	
	// del cart item
	function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
	
	// clear cart
	function clear_cart(){
		if(confirm('This will empty your shopping cart, continue?')){
			document.form1.command.value='clear';
			document.form1.submit();
		}
	}
	
	// update cart
	function update_cart(){
		document.form1.command.value='updatecart';
		document.form1.submit();
	}	
	
	// window on load javascript functions to be called
	window.onload = function() {
		exefunction();	
	}
	
	function dec_qty(pid){
		var p_id = "#qty_pro_"+pid;
		if($(p_id).val() > 1){
		  $(p_id).val( Number($(p_id).val()) - 1 );
		}	
	}
	
	function inc_qty(pid){
		var p_id = "#qty_pro_"+pid;
		$(p_id).val( Number($(p_id).val()) + 1 );
	}
	
	// check on page if it is product
	function exefunction(){
		var product = document.getElementById("product_check").checked;
		
		if(product == true){
			document.getElementById('product_name_title').style.display = 'block';
			document.getElementById('product_content_title').style.display = 'block';
			document.getElementById('product_visible_title').style.display = 'block';
			document.getElementById('product_image_title').style.display = 'block';
		}else{
			document.getElementById('product_name_title').style.display = 'none';
			document.getElementById('product_content_title').style.display = 'none';
			document.getElementById('product_visible_title').style.display = 'none';
			document.getElementById('product_image_title').style.display = 'none';
		}
	}	
	