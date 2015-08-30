   <!--main-Slider -->
    
      <div class="hidden-xs bb-custom-wrapper">
        <div id="bb-bookblock" class="bb-bookblock">
          <div class="bb-item">
            <div class="bb-custom-firstpage">
              <h1><span>New Product </span>A Christmas Gift</h1>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
            <div class="bb-custom-side"> <img src="images/slider-img.png" /> </div>
          </div>
          <div class="bb-item">
            <div class="bb-custom-firstpage">
              <h1><span>New Product 2 </span>A Christmas Gift</h1>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
            <div class="bb-custom-side"> <img src="images/slider-img.png" /> </div>
          </div>
          <div class="bb-item">
            <div class="bb-custom-firstpage">
              <h1><span>New Product 3 </span>A Christmas Gift</h1>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
            <div class="bb-custom-side"> <img src="images/slider-img.png" /> </div>
          </div>
          <div class="bb-item">
            <div class="bb-custom-firstpage">
              <h1><span>New Product 4</span>A Christmas Gift</h1>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
            <div class="bb-custom-side"> <img src="images/slider-img.png" /> </div>
          </div>
        </div>
        <div class="slider-nav"> <a id="bb-nav-prev" href="#" ><img src="images/pre-arrow.png"></a> <a id="bb-nav-next" href="#" ><img src="images/next-arrow.png"></a>
          </nav>
        </div>
      </div>
      <div  class="hidden-xs slider-bg">&nbsp;</div>
      
      <!--/main-Slider -->			
			
			<?php	
				
				echo site_options('welcome');
				
				$pagination = pagination(site_options('new_products'),'products');
				echo '<div class="row"><div class="col-lg-12"><h3 class="pro-header">New Products</h3></div>';				
				while($product = mysql_fetch_array($pagination['query'])){
					include('products_loop.php');
				}
				echo '</div>';	
				echo $pagination['index'];
			?>	