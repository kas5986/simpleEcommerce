
	
	</div><!-- body area ends .// -->  
  


	<footer>
	
		<div class="copyrights">Copyrights &copy; 2013 &nbsp; <?php echo site_options('title'); ?></div>
	
	</footer>

  

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo site_options('link'); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo site_options('link'); ?>/js/summernote.min.js"></script>
	
	<!-- designing scripts -->
    <script src="<?php echo site_options('link'); ?>/js/modernizr.custom.js"></script>
    <script src="<?php echo site_options('link'); ?>/js/jquerypp.custom.js"></script>
    <script src="<?php echo site_options('link'); ?>/js/jquery.bookblock.js"></script>
	<script type="text/javascript">
		$(window).load(function(){
			$('#help').modal('show');
		});
	</script>		
	
	<!-- longhorn vapor core javascript -->
	<script type="text/JavaScript">
	
		$(document).ready(function() {

		
			// for tooltips 
			$('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});

			if($('#page_content').length == true){
				$('#page_content').summernote({
					height: 200,   //set editable area's height
					focus: true    //set focus editable area after Initialize summernote
				});
				$('#page_content').code($('textarea[name="page_content"]').text());
				
			} 
			else if ($('#subject_content').length == true){
				$('#subject_content').summernote({
					height: 200,   //set editable area's height
					focus: true    //set focus editable area after Initialize summernote
				});
				$('#subject_content').code($('textarea[name="subject_content"]').text());
			} 
			else if ($('#site_welcome').length == true){
				$('#site_welcome').summernote({
					height: 200,   //set editable area's height
					focus: true    //set focus editable area after Initialize summernote
				});
				$('#site_welcome').code($('textarea[name="site_welcome"]').text());	
			}
		
		});
		
		// summernote form return values !
		var postWelcome = function() {
		var site_welcome = $('textarea[name="site_welcome"]').html($('#site_welcome').code());
		
		}
		var postPage = function() {
		var page_content = $('textarea[name="page_content"]').html($('#page_content').code());
		}
		var postSubject = function() {
		var subject_content = $('textarea[name="subject_content"]').html($('#subject_content').code());
		}		
	</script>
	<!-- longhorn vapor core javascript --> 
 <script>
			var Page = (function() {
				
				var config = {
						$bookBlock : $( '#bb-bookblock' ),
						$navNext : $( '#bb-nav-next' ),
						$navPrev : $( '#bb-nav-prev' ),
						$navFirst : $( '#bb-nav-first' ),
						$navLast : $( '#bb-nav-last' )
					},
					init = function() {
						config.$bookBlock.bookblock( {
							speed : 1000,
							shadowSides : 0.8,
							shadowFlip : 0.8,
							autoplay : true,
							interval : 4000
						} );
						initEvents();
					},
					initEvents = function() {
						
						var $slides = config.$bookBlock.children();

						// add navigation events
						config.$navNext.on( 'click touchstart', function() {
							config.$bookBlock.bookblock( 'next' );
							return false;
						} );

						config.$navPrev.on( 'click touchstart', function() {
							config.$bookBlock.bookblock( 'prev' );
							return false;
						} );

						config.$navFirst.on( 'click touchstart', function() {
							config.$bookBlock.bookblock( 'first' );
							return false;
						} );

						config.$navLast.on( 'click touchstart', function() {
							config.$bookBlock.bookblock( 'last' );
							return false;
						} );
						
						// add swipe events
						$slides.on( {
							'swipeleft' : function( event ) {
								config.$bookBlock.bookblock( 'next' );
								return false;
							},
							'swiperight' : function( event ) {
								config.$bookBlock.bookblock( 'prev' );
								return false;
							}
						} );

						// add keyboard events
						$( document ).keydown( function(e) {
							var keyCode = e.keyCode || e.which,
								arrow = {
									left : 37,
									up : 38,
									right : 39,
									down : 40
								};

							switch (keyCode) {
								case arrow.left:
									config.$bookBlock.bookblock( 'prev' );
									break;
								case arrow.right:
									config.$bookBlock.bookblock( 'next' );
									break;
							}
						} );
					};

					return { init : init };

			})();
		</script> 
<script>
				Page.init();
		</script> 
  </body>
</html>  
  
<?php close_connection(); ?>  