<?php 	
	require_once('includes/header.php'); 

	include_once("includes/form_functions.php");
	
	require_once('includes/recaptchalib.php');
	
	if(isset($_SESSION['user_id'])){
		redirect_to('index.php');
	}
	

// this is for google recaptcha plugin for form spam validation

// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = CAPTCHA_PUBLIC;
$privatekey = CAPTCHA_PRIVATE;

# the response from reCAPTCHA
$resp = null;	
# the error code from reCAPTCHA, if any
$error = null;

	
	// START FORM PROCESSING
	if (isset($_POST['login'])) { // Form has been submitted.
		
		$varify = $_POST["recaptcha_response_field"];
	
		# was there a reCAPTCHA response?
		if (isset($varify) || empty($varify)) {
				$resp = recaptcha_check_answer ($privatekey,
												$_SERVER["REMOTE_ADDR"],
												$_POST["recaptcha_challenge_field"],
												$_POST["recaptcha_response_field"]);

			if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
			$message = '<p class="alert alert-danger">The reCAPTCHA wasn\'t entered correctly. Try it again.</p>';
				// fill if incorrect !
				$username = $_POST['user_name'];
			}else{
				$errors = array();

				// perform validations on the form data
				$required_fields = array('user_name', 'user_password');
				$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

				$fields_with_lengths = array('user_name' => 30, 'user_password' => 30);
				$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

				$username = trim(mysql_prep($_POST['user_name']));
				$password = trim(mysql_prep($_POST['user_password']));
				$hashed_password = sha1($password);
				
				if ( empty($errors) ) {
					// Check database to see if username and the hashed password exist there.
					$query = "SELECT id, username, user_type, email, address, phone, name ";
					$query .= "FROM users ";
					$query .= "WHERE username = '{$username}' ";
					$query .= "AND hashed_password = '{$hashed_password}' ";
					$query .= "AND activation = 1 ";
					$query .= "LIMIT 1";
					$result_set = mysql_query($query);
					confirm_query($result_set);
					if (mysql_num_rows($result_set) == 1) {
						// username/password authenticated
						// and only 1 match
						$found_user = mysql_fetch_array($result_set);
						
						// fill out all the session requirment !
						$_SESSION['user_id'] = $found_user['id'];
						$_SESSION['user_address'] = $found_user['address'];
						$_SESSION['user_phone'] = $found_user['phone'];
						$_SESSION['user_name'] = $found_user['name'];
						$_SESSION['session_id'] = sha1($found_user['email']);
						$_SESSION['email'] = $found_user['email'];
						$_SESSION['username'] = $found_user['username'];
						$_SESSION['user_type'] = $found_user['user_type'];
						redirect_to("content.php?loggedin=".$_SESSION['session_id']);
					} else {
						// username/password combo was not found in the database
						$message = '<p class="alert alert-warning">Username/password combination incorrect or User not activated!</p>';
					}
				} else {
					if (count($errors) == 1) {
						$message = '<p class="alert alert-warning">There was 1 error in the form.</p>';
					} else {
						$message = '<p class="alert alert-warning">There were ' . count($errors) . ' errors in the form.</p>';
					}
				}				
			}
		}
	
	} else { // Form has not been submitted.
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$message = '<p class="alert alert-success">You are now logged out.</p>';
		} 
		$username = "";
		$password = "";
	}


?>	
	
		<div class="row">
		
			<?php include('theme/sidebar.php'); ?>
			
			
			<article class="col-lg-9">

				<form class="form-horizontal"  role="form" method="post">
				<fieldset>

				<!-- Form Name -->
			<?php if (!empty($message)) {echo $message;} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-sm-3 control-label" for="user_name">User Name *</label>
				  <div class="col-sm-9">
					<input id="user_name" name="user_name" placeholder="User Name" class="form-control" required="" value="<?php echo htmlentities($username);?>" type="text">
					<p class="help-block">Please enter username (No Space)</p>
				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-sm-3 control-label" for="user_password">Password *</label>
				  <div class="col-sm-9">
					<input id="user_password" name="user_password" placeholder="Password" class="form-control" required="" type="password">
					<p class="help-block">Please type password mixed case.</p>
				  </div>
				</div>


				  
				  <div class="form-group">
				  <div class="col-sm-offset-3 col-sm-9">
					<?php echo recaptcha_get_html($publickey, $error); ?>
				  </div></div>				
				
				<!-- Button (Double) -->
				<div class="form-group">
				  
				  <div class="col-sm-offset-3 col-sm-9">
					<button type="submit" id="login" name="login" class="btn btn-default">Login</button>
					<button type="reset" class="btn btn-danger">Reset</button>
				  </div>
				</div>

				</fieldset>
				</form>
			</article>
		
	
	
		</div>

<?php require_once('includes/footer.php'); ?>