<?php 
require_once("connection.php"); 
require_once("session.php");
require_once("functions.php"); 
require_once("cart_functions.php"); 
require_once("header_inc.php");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo site_options('title'); if (!empty($sel_page['id'])){ echo ' | ' . $sel_page['page_name']; } ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_options('link'); ?>/css/stylesheet.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo site_options('link'); ?>/assets/js/html5shiv.js"></script>
      <script src="<?php echo site_options('link'); ?>/assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo site_options('link'); ?>/js/cart_script.js"></script>

    <script src="<?php echo site_options('link'); ?>/assets/js/jquery.js"></script>	
	<style>
	
	.long-string{
	    overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	
	
	</style>
	
	
  </head>
  
  
  <body>
 
<nav  role="navigation" class="navbar navbar-inverse navbar-fixed-top">
  <!-- Brand and toggle get grouped for better mobile display -->
  
  <div class="container">
  
    <div class="navbar-header">
      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div  class="collapse navbar-collapse">
    
	<ul class="nav navbar-nav">
			<?php get_navigation(2, 'top'); ?>
    </ul>
    <!--<form class="navbar-form navbar-left" role="search">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>-->
    <ul class="nav navbar-nav navbar-right">
	  
		<?php if(logged_in()){ ?>
			<li><a href="<?php echo site_options('link'); ?>/logout.php">Logout</a></li>      
			<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){ ?>
			<li><a href="<?php echo site_options('link'); ?>admin/index.php">Admin</a></li>
			<?php } ?>
			<!--<?php echo nav_shopping_cart(); ?>-->
			<li><a href="<?php echo site_options('link'); ?>/shoppingcart.php"><i class="fa fa-shopping-cart"></i>&nbsp;Cart</a></li>
			
		<?php } else {?>
			<li><a href="<?php echo site_options('link'); ?>/login.php">Login</a></li>
			<li><a href="<?php echo site_options('link'); ?>/register.php">Register</a></li>
		<?php }?>
	  

		
    </ul>
	
	</div><!-- /.navbar-collapse -->
	
  </div>
</nav>

<div class="page-header">

	<div class="container">
		
    <div class="row custom_margin">

			<div class="col-md-4">
				<div class="logo">
					<a href="<?php echo site_options('link'); ?>content.php">
					<img src="<?php echo site_options('link').site_options('logo'); ?>"  class="pull-left" >
					</a>
				</div>	
			</div>	
			
			<div class="col-md-8  pull-right text-right top-text">
				<h1 class="hidden-xs top-text"><?php echo site_options('title'); ?></h1>
				<p><?php echo site_options('description'); ?></p>
			</div>
		</div>
	</div>
	
</div>



<!-- header ends .///-->


	<div class="container">