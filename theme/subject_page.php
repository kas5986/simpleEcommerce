<div class="row">
	<div class="col-lg-12">
	
	<?php if($sel_subject && !$sel_subject_child){ ?>
		
			<h1><?php echo $sel_subject['name']; ?></h1>
			<p><?php echo $sel_subject['content']; ?></p>

<?php			

			
				echo '<div class="row"><div class="col-lg-12"><h3 class="pro-header">' .$sel_subject['name']. '</h3></div>';				
						
						$pagination = pagination(site_options('new_products'),'cat_products', $sel_subject['id']);
						
						while($product = mysql_fetch_array($pagination['query'])){
							include('products_loop.php');
						}

				echo '</div>';
				echo $pagination['index'];
			
							
?>									
	<?php } else { ?>		
			
			<h1><?php echo $sel_subject_child['name']; ?></h1>					
			<p><?php echo $sel_subject_child['content']; ?></p>	


<?php		
			if(isset($_GET['child'])){	
				echo '<div class="row"><div class="col-lg-12"><h3 class="pro-header">' .$sel_subject_child['name']. '</h3></div>';				
						
						$pagination = pagination(site_options('new_products'),'cat_products', $sel_subject_child['id']);
						
						while($product = mysql_fetch_array($pagination['query'])){
							include('products_loop.php');
						}
						echo $pagination['index'];

				echo '</div>';	
			}
?>	
			
	
	<?php } ?>
	
	</div>
</div>
