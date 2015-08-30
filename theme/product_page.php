				<div class="row">
					<?php if (!empty($sel_product['id'])){ ?>
					<div class="col-lg-5">
						<a href="#"><img height="100%" width="100%" src="<?php echo $sel_product['picture'] ?>" class="thumbnail" data-toggle="modal" data-target="#myModal" /></a>
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel"><?php echo $sel_product['name']; ?></h4>
							  </div>
							  <div class="modal-body">
								<img class="thumbnail" height="100%" width="100%" src="<?php echo $sel_product['picture']; ?>" />
								
							  </div>
							</div><!-- /.modal-content -->
						  </div><!-- /.modal-dialog -->
						</div><!-- /.modal -->						
					</div>
					
					<div class="col-lg-7">
					
						<h3><?php echo $sel_page['page_name']; ?> </h3>
						<?php if(logged_in()) { ?>
						<h3 style="color: green;">$<?php echo $sel_product['price']; ?> </h3>
						<?php } else { ?>
						<a href="<?php echo site_options('link'); ?>/login.php">Login</a>
						<?php } ?>
						<p><?php echo $sel_product['description']; ?> </p><br /><br />
							<div class="input-group">
							  <div class="btn-group">
								<button class="btn btn-default" onclick="dec_qty(<?php echo $sel_product['id'];?>)" type="button">-</button>
							  </div>
							  <input type="text" name="qty_pro" readonly class="qty_pro form-control input-length" id="qty_pro_<?php echo $sel_product['id'];?>" value="1" />
							  <div class=" btn-group ">
								<button class="btn btn-default"  onclick="inc_qty(<?php echo $sel_product['id'];?>)" type="button">+</button>
							  </div>
							</div>          	
				
							<div class="custom_margin_2">
								<textarea class="form-control" name="qty_pro_note" id="pro_note_<?php echo $sel_product['id'];?>" rows="2" placeholder="Message">Variations...</textarea>                
							</div>	
							
						<?php if(logged_in()) { ?>
						<input type="button" class="btn btn-success" value="Add to Cart" onclick="addtocart(<?php echo $sel_product['id']?>)" />
						<?php } else { ?>
						<input type="button" class="btn btn-warning" value="Register" onclick="location.href='<?php echo site_options('link').'/register.php' ?>'" />
						<?php } ?>
					</div>
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-lg-12">
					<?php if(empty($sel_product['id'])){ ?>
					<h3><?php echo $sel_page['page_name']; ?> </h3>
					<?php } ?>
					<p><?php echo $sel_page['page_value']; ?></p>
					</div>
				</div>	