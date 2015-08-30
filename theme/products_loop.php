<?php $sel_page = get_page_by_id($product['page_id']); ?>

					<div class="col-sm-6 col-lg-4 product ">
					  <div class="thumbnail pro-border ">
						<div class="container-item">
							
							<div class="item">
								<a href="<?php echo site_options('link').'content.php?page='. $product['page_id']; ?>"><img src="<?php echo $product['picture']; ?>" height="100%" width="100%"></a>
								<div class="item-overlay"> 
								<a class="item-button play" <?php if(logged_in()) { ?> href="#" onclick="addtocart(<?php echo $product['id'];?>)"</a> <?php } else {echo 'href="' . site_options('link').'/login.php"';} ?>>
								<i class="play"></i>
								
								<a class="item-button share share-btn" href="" data-toggle="modal" data-target="#myModal-<?php echo $product['id'];?>"><i class="cart"></i></a>




								</div>

						

							<div class="item-content">
							  <div class="item-top-content">
								<div class="item-top-content-inner">
								  <div class="item-product">	 
									<div class="item-top-title">
									  <p class="subdescription long-string"  data-toggle="tooltip"><a href="<?php echo site_options('link').'content.php?page='. $product['page_id']; ?>"><?php echo $product['name']; ?></a></p>
									</div>
								  </div>
								 
								 <div class="item-product-price"> <?php if(logged_in()) { ?> <span class="price-num">$<?php echo $product['price']; ?></span><?php } ?>
								  
								  </div>
								</div>
							  </div>
							  <div class="item-add-content">
								<div class="item-add-content-inner"> 
								  <div class="section"> <a class="btn buy expand" href="<?php echo site_options('link').'content.php?page='. $product['page_id']; ?>">Buy now</a> </div>
								</div>
							  </div>
							</div>
						  </div>
						</div>
						
					  </div>
					</div>
					
	<!-- Modal -->
	<div class="modal fade" id="myModal-<?php echo $product['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><?php echo $sel_page['page_name']; ?></h4>
		  </div>
		  <div class="modal-body">
		  
			<div class=" media col-sm-6">
				<img src="<?php echo $product['picture'] ?>" />
			</div>
        
			<div class="col-lg-6" style="height:250px;">
				<h4 class="media-heading"><?php echo $product['name'] ?></h4>
				<p><?php echo $product['description'] ?></p>
				
				<div class="input-group">
				  <div class="btn-group">
					<button class="btn btn-default" onclick="dec_qty(<?php echo $product['id'];?>)" type="button">-</button>
				  </div>
				  <input type="text" name="qty_pro" readonly class="qty_pro form-control input-length" id="qty_pro_<?php echo $product['id'];?>" value="1" />
				  <div class=" btn-group ">
					<button class="btn btn-default"  onclick="inc_qty(<?php echo $product['id'];?>)" type="button">+</button>
				  </div>
				</div>	          	
				
				<div class="custom_margin_2">
					<textarea class="form-control" name="qty_pro_note" id="pro_note_<?php echo $product['id'];?>" rows="2" placeholder="Message">Variations...</textarea>                
				</div>	
			<hr>		
			</div>
			
			<div><?php echo $sel_page['page_value']; ?></div>
			

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<?php if(logged_in()) { ?>
						<input type="button" class="btn btn-primary" value="Add to Cart" onclick="addtocart(<?php echo $product['id'];?>)" />
						<?php } else { ?>
						<input type="button" class="btn btn-warning" value="Register" onclick="location.href='<?php echo site_options('link').'/register.php' ?>'" />
						<?php } ?>
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->						
					