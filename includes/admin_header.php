<?php 
require_once("connection.php"); 
require_once("session.php");
require_once("functions.php"); 
require_once("cart_functions.php"); 
require_once("header_inc.php");
confirm_admin();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo site_options('title'); ?></title>

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
 
<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  
  <div class="container">
  
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#"><?php echo site_options('title'); ?></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    
	<ul class="nav navbar-nav">
			<?php get_navigation(2, 'top'); ?>
    </ul>

    <ul class="nav navbar-nav navbar-right">
      <li><a href="<?php echo site_options('link'); ?>/index.php">Visit Site</a></li>
	  <li><?php if(logged_in()){ ?>
	  <a href="<?php echo site_options('link'); ?>/logout.php">Logout</a>
	  <?php } else {?>
	  <a href="<?php echo site_options('link'); ?>/login.php">Login</a>
	  <?php }?>
	  </li>
    </ul>
	
	</div><!-- /.navbar-collapse -->
	
  </div>
</nav>




<!-- header ends .///-->


	<div class="container">