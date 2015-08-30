<?php 
	require_once('includes/header.php'); 
	require_once('includes/functions.php');
	require_once('includes/recaptchalib.php');
	
	
// this is for google recaptcha plugin for form spam validation

// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = CAPTCHA_PUBLIC;
$privatekey = CAPTCHA_PRIVATE;

# the response from reCAPTCHA
$resp = null;	
# the error code from reCAPTCHA, if any
$error = null;
	
?>
<?php 
	if(isset($_SESSION['user_id'])){
		redirect_to('index.php');
	}
	include_once("includes/form_functions.php");
	

	// START FORM PROCESSING
	if (isset($_POST['register'])) { // Form has been submitted.
		
		$varify = $_POST["recaptcha_response_field"];
	
		# was there a reCAPTCHA response?
		if (isset($varify) || empty($varify)) {
				$resp = recaptcha_check_answer ($privatekey,
												$_SERVER["REMOTE_ADDR"],
												$_POST["recaptcha_challenge_field"],
												$_POST["recaptcha_response_field"]);

			if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
			$message = '<p class="alert alert-danger">The reCAPTCHA wasn\'t entered correctly. Try it again.' .
				 'reCAPTCHA said: ' . $resp->error . '</p>';
				 
				 
					$username = $_POST['user_name'];
					$password = '';
					$password_confirm = '';
					$user_email = $_POST['user_email'];
					$user_address = $_POST['user_address'];
					$user_realname = $_POST['user_realname'];
					$user_job = $_POST['user_job'];
					$user_phone = $_POST['user_phone'];
					$user_mobile = $_POST['user_mobile'];
					$user_fax = $_POST['user_fax'];
					$company_name = $_POST['company_name'];
					$company_website = $_POST['company_website'];	
					$company_address = $_POST['company_address'];	
					$company_city = $_POST['company_city'];	
					$company_state = $_POST['company_state'];		
					$company_zip = $_POST['company_zip'];		
					$company_country = $_POST['company_country'];	
					$company_years = $_POST['company_years'];
					$company_started =  $_POST['company_started'];
					$company_tax = $_POST['company_tax'];				 
				 
				 
			} else {
			
	
				$errors = array();
				// perform validations on the form data
				$required_fields = array('user_name', 'user_password');
				$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

				$fields_with_lengths = array('user_name' => 30, 'user_password' => 30);
				$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
				
				// registration fields
				$username = trim(mysql_prep($_POST['user_name']));
				$user_realname = mysql_prep($_POST['user_realname']);
				$password = trim(mysql_prep($_POST['user_password']));
				$password_confirm = trim(mysql_prep($_POST['password_confirm']));
				$user_email = trim(mysql_prep($_POST['user_email']));
				$hashed_password = sha1($password);
				
				// contact info fields
				$user_job = mysql_prep($_POST['user_job']);
				$user_phone = mysql_prep($_POST['user_phone']);
				$user_fax = mysql_prep($_POST['user_fax']);
				$user_mobile = mysql_prep($_POST['user_mobile']);
				$user_address = mysql_prep($_POST['user_address']);	
				
				// company info fields
				$company_name = mysql_prep($_POST['company_name']);	
				$company_website = trim(mysql_prep($_POST['company_website']));	
				$company_address = mysql_prep($_POST['company_address']);	
				$company_city = mysql_prep($_POST['company_city']);		
				$company_state = mysql_prep($_POST['company_state']);		
				$company_zip = trim(mysql_prep($_POST['company_zip']));		
				$company_country = trim(mysql_prep($_POST['company_country']));	
				$company_years = trim(mysql_prep($_POST['company_years']));
				$company_started = trim(mysql_prep($_POST['company_started']));
				$company_tax = mysql_prep($_POST['company_tax']);		

				
				
				if ( empty($errors) ) {
					// check if user already exist !
					$valid_name = "SELECT username FROM users WHERE username='{$username}' OR email = '{$user_email}'";
					$valid = mysql_query($valid_name, $connection);
					$num_rows = mysql_num_rows($valid);
					
					if($num_rows < 1){
							$query = "INSERT INTO users (
											username,
											name,
											hashed_password, 
											email, address, 
											activation, 
											user_type, 
											job, 
											phone, 
											mobile, 
											fax,
											company_name,
											company_website,
											company_address,
											company_city,
											company_state,
											company_zip,
											company_country,
											company_years,
											company_started,
											company_tax) 
									VALUES (
											'{$username}',
											'{$user_realname}', 
											'{$hashed_password}', 
											'{$user_email}',
											'{$user_address}',
											0,  
											2,  
											'{$user_job}', 
											'{$user_phone}', 
											'{$user_mobile}', 
											'{$user_fax}',
											'{$company_name}',
											'{$company_website}',
											'{$company_address}',
											'{$company_city}',
											'{$company_state}',
											'{$company_zip}',
											'{$company_country}',
											'{$company_years}',
											'{$company_started}',
											'{$company_tax}'
									)";
									
						$result = mysql_query($query, $connection);			
						
						if ($result) {
							$message = '<p class="alert alert-success">The user was successfully created.</p>';
							
							// send email after success registration !
							$mail_subject = "Recieved your application at: ". site_options('title');
							$email_message = "Hello! Your application is been recieved and will be reviewed shortly will send you confirmation after review, Thanks.";
							$from = site_options('email');
							$mail_headers = "From:" . $from;
							mail($user_email,$mail_subject,$email_message,$mail_headers);
							

							// send email after user activation to admin !
							$mail_subject = "New Application Recieved: ". $company_name;
							$email_message = 'New application recieved, company name is '.$company_name.' , Thanks.';
							$from = $user_email;
							$mail_headers = "From:" . $from;
							mail(site_options('email'),$mail_subject,$email_message,$mail_headers);							
							
							
						} else {
							$message = '<p class="alert alert-warning">The user could not be created.</p>';
							$message .= "<br />" . mysql_error();
						}
					}else{
						$message = '<p class="alert alert-warning">The user already exists with username or email !</p>';
					}				
				
					$username = '';
					$password = '';
					$password_confirm = '';
					$user_email = '';
					$user_address = '';
					$user_realname = '';
					$user_job = '';
					$user_phone = '';
					$user_mobile = '';
					$user_fax = '';
					$company_name = '';
					$company_website = '';	
					$company_address = '';	
					$company_city = '';	
					$company_state = '';		
					$company_zip = '';		
					$company_country = '';	
					$company_years = '';
					$company_started =  '';
					$company_tax = '';

				} else {
					if (count($errors) == 1) {
						$message = '<p class="alert alert-danger">There was 1 error in the form.</p>';
					} else {
						$message = '<p class="alert alert-danger">There were ' . count($errors) . ' errors in the form.</p>';
					}
				}			
			
			
			
			}

		}		
	
	

	} else { // Form has not been submitted.
		$username = '';
		$password = '';
		$password_confirm = '';
		$user_email = '';
		$user_address = '';
		$user_realname = '';
		$user_job = '';
		$user_phone = '';
		$user_mobile = '';
		$user_fax = '';
		$company_name = '';
		$company_website = '';	
		$company_address = '';	
		$company_city = '';	
		$company_state = '';		
		$company_zip = '';		
		$company_country = '';	
		$company_years = '';
		$company_started =  '';
		$company_tax = '';
	}

?>		
		<div class="row">
		
			<?php include('theme/sidebar.php'); ?>
			
			
			<article class="col-lg-9">
			<center><h3>Register</h3></center>
			<?php if (!empty($message)) {echo $message;} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>		
			
				<form class="form-horizontal" action="<?php echo site_options('link').'/register.php';?>" role="form" method="post">
				
				  <div class="form-group">
					<label for="user_name" class="col-sm-2 control-label">User Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_name" name="user_name" required="" value="<?php echo htmlentities($username); ?>">
					</div>
				  </div>

				 <div class="form-group">
					<label for="user_password" class="col-sm-2 control-label">User Password</label>
					<div class="col-sm-10">
					  <input type="password" class="form-control" id="user_password" name="user_password" required="" value="<?php echo htmlentities($password); ?>">
					</div>
				  </div>				  

				  <div class="form-group">
					<label for="password_confirm" class="col-sm-2 control-label">Confirm Password</label>
					<div class="col-sm-10">
					  <input type="password" class="form-control" id="password_confirm" name="password_confirm" required="" value="<?php echo htmlentities($password_confirm); ?>">
					</div>
				  </div>				  
					<center><h3>User Contact info.</h3></center>
				  <div class="form-group">
					<label for="user_realname" class="col-sm-2 control-label">Full Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_realname" name="user_realname" required="" value="<?php echo htmlentities($user_realname); ?>">
					</div>
				  </div>		
				  
				  <div class="form-group">
					<label for="user_email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
					  <input type="email" class="form-control" id="user_email" name="user_email" required="" value="<?php echo htmlentities($user_email); ?>">
					</div>
				  </div>

				  <div class="form-group">
					<label for="user_job" class="col-sm-2 control-label">Job Title</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_job" name="user_job" required="" value="<?php echo htmlentities($user_job); ?>">
					</div>
				  </div>				  
				  
				  <div class="form-group">
					<label for="user_address" class="col-sm-2 control-label">Full Address</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_address" name="user_address" required="" value="<?php echo htmlentities($user_address); ?>">
					</div>
				  </div>				  
				  
				  <div class="form-group">
					<label for="user_phone" class="col-sm-2 control-label">Office Phone#</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_phone" name="user_phone" required="" value="<?php echo htmlentities($user_phone); ?>">
					</div>
				  </div>	
				  
				  <div class="form-group">
					<label for="user_mobile" class="col-sm-2 control-label">Mob#</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_mobile" name="user_mobile" value="<?php echo htmlentities($user_mobile); ?>">
					</div>
				  </div>	
				  
				  <div class="form-group">
					<label for="user_fax" class="col-sm-2 control-label">Fax#</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_fax" name="user_fax" value="<?php echo htmlentities($user_fax); ?>">
					</div>
				  </div>					  

					<center><h3>Company info.</h3></center>	
				  
				  <div class="form-group">
					<label for="company_name" class="col-sm-2 control-label">Company Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_name" name="company_name" required="" value="<?php echo htmlentities($company_name); ?>">
					</div>
				  </div>	
				  
				  <div class="form-group">
					<label for="company_website" class="col-sm-2 control-label">Website</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_website" name="company_website" value="<?php echo htmlentities($company_website); ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_address" class="col-sm-2 control-label">Address</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_address" name="company_address" required="" value="<?php echo htmlentities($company_address); ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_city" class="col-sm-2 control-label">City</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_city" name="company_city" required="" value="<?php echo htmlentities($company_city); ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_state" class="col-sm-2 control-label">Stale</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_state" name="company_state" required="" value="<?php echo htmlentities($company_state); ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_zip" class="col-sm-2 control-label">Zip</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_zip" name="company_zip" required="" value="<?php echo htmlentities($company_zip); ?>">
					</div>
				  </div>
				  
					<?php
					 
					$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

					?>				  
				  <div class="form-group">
					<label for="company_country" class="col-sm-2 control-label">country</label>
					<div class="col-sm-10">
					  <select id="company_country" name="company_country" class="form-control">
						<?php 
							  foreach($countries as $country){
								echo '<option value="'.$country .'">'.$country .'</option>';
							  }						
						?>
					  </select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_years" class="col-sm-2 control-label">Business Entry Years</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_years" name="company_years" required="" value="<?php echo htmlentities($company_years); ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_started" class="col-sm-2 control-label">Business Established</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_started" name="company_started" required="" value="<?php echo htmlentities($company_started); ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_tax" class="col-sm-2 control-label">Fedral Tax ID</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_tax" name="company_tax" required="" value="<?php echo htmlentities($company_tax); ?>">
					</div>
				  </div>				  
				  
				  
				  <div class="form-group">
				  <div class="col-sm-offset-2 col-sm-10">
					<?php echo recaptcha_get_html($publickey, $error); ?>
				  </div></div>
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name="register" class="btn btn-default">Register</button>
						<a class="btn btn-danger" href="<?php echo site_options('link'); ?>/index.php">cancel</a>
					</div>
				  </div>
				  
				</form>
			</article>
		
	
	
		</div>

<?php require_once('includes/footer.php'); ?>