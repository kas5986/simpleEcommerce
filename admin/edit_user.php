<?php 
	require_once('../includes/admin_header.php'); 
	require_once('includes/admin_functions.php');
	if (intval($_GET['user']) == 0) {
		redirect_to('users_index.php');
	}	
	// get user details !
	if(isset($_GET['user'])){
		$sel_user = get_user_by_id($_GET['user']);		
		
		if(isset($_GET['success'])){
		$message = '<p class="alert alert-success">The user was successfully created.</p>';
			
			if($sel_user['activation'] == 1){
				// send email after user activation !
				$mail_subject = "Your Application Approved at: ". site_options('title');
				$email_message = "Hello! Your application is been approved, you may now login with your userid and password which you submited in your application , Thanks.";
				$from = site_options('email');
				$mail_headers = "From:" . $from;
				mail($sel_user['email'],$mail_subject,$email_message,$mail_headers);		
			}
		}else{
		$message = '';
		}
		
	}else{
		$sel_user = NULL;
	}	
	
?>


<?php 

	include_once("../includes/form_functions.php");
	
	// START FORM PROCESSING
	if (isset($_POST['update'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('user_name');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('user_name' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$username = trim(mysql_prep($_POST['user_name']));
		$user_realname = mysql_prep($_POST['user_realname']);
		//$password = trim(mysql_prep($_POST['user_password']));
		//$password_confirm = trim(mysql_prep($_POST['password_confirm']));
		$user_email = trim(mysql_prep($_POST['user_email']));
		$user_address = mysql_prep($_POST['user_address']);
		$activation = trim(mysql_prep($_POST['user_activation']));
		$user_type = trim(mysql_prep($_POST['user_type']));
		//$hashed_password = sha1($password);
		
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
			
			
			$query = "UPDATE users 
					SET username = '{$username}', 
					name = '{$user_realname}', 
					email = '{$user_email}',
					activation = {$activation},
					user_type = {$user_type},
					job = '{$user_job}',
					address = '{$user_address}',
					phone = '{$user_phone}',
					mobile = '{$user_mobile}',
					fax = '{$user_fax}',
					company_name = '{$company_name}',
					company_website = '{$company_website}',
					company_address = '{$company_address}',
					company_city = '{$company_city}',
					company_state = '{$company_state}',
					company_zip = {$company_zip},
					company_country = '{$company_country}',
					company_years = '{$company_years}',
					company_started = '{$company_started}',
					company_tax = '{$company_tax}' 
					 WHERE id = {$_GET['user']} ";
					
				$result = mysql_query($query, $connection);			
				
				if ($result) {
				
					//$message = '<p class="alert alert-success">The user was successfully created.</p>';
					redirect_to('edit_user.php?success=1&user='.$_GET['user']);
				} else {
					$message = '<p class="alert alert-warning">The user could not be created.</p>';
					$message .= "<br />" . mysql_error();
				}
						

		} else {
			if (count($errors) == 1) {
				$message = '<p class="alert alert-danger">There was 1 error in the form.</p>';
			} else {
				$message = '<p class="alert alert-danger">There were ' . count($errors) . ' errors in the form.</p>';
			}
		}
	} else { // Form has not been submitted.

	}

?>

	
		<div class="row">
		
			<?php include('admin_sidebar.php'); ?>
			
			
			<article class="col-lg-9">
			<?php if (!empty($message)) {echo $message;} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>					
			<h3>Edit : <?php echo $sel_user['username']; ?></h3>
				<form id="options" class="form-horizontal" action="" role="form" method="post">
					<input type="hidden" name="user_id" value="<?php echo $sel_user['id']; ?>" />
				  <div class="form-group">
					<label for="user_name" class="col-sm-2 control-label">User Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_name" name="user_name" required="" value="<?php echo $sel_user['username']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="user_realname" class="col-sm-2 control-label">Full Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_realname" name="user_realname" required="" value="<?php echo $sel_user['name']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="user_password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
					  <input type="password" class="form-control" id="user_password" name="user_password" required="" value=""  disabled>
					</div>
				  </div>	
				  <div class="form-group">
					<label for="password_confirm" class="col-sm-2 control-label">Confirm Password</label>
					<div class="col-sm-10">
					  <input type="password" class="form-control" id="password_confirm" name="password_confirm" required="" value=""  disabled>
					</div>
				  </div>	
				  <div class="form-group">
					<label for="user_email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
					  <input type="email" class="form-control" id="user_email" name="user_email" required="" value="<?php echo $sel_user['email']; ?>">
					</div>
				  </div>	
		  
				  <div class="form-group">
					<div>
					<label for="user_activation" class="col-sm-2 control-label">Activation</label>
					<div class="col-sm-2">
					  <input type="radio" class="radio-inline" id="user_activation" name="user_activation" value="0"
					  <?php if( $sel_user['activation'] == 0){echo ' checked';} ?>> No &nbsp;
					  <input type="radio" class="radio-inline" id="user_activation" name="user_activation" value="1" 
					  <?php if( $sel_user['activation'] == 1){echo ' checked';} ?>> Yes &nbsp;
					</div>
					<label for="user_type" class="col-sm-2 control-label">User Type</label>
					<div class="col-sm-3 input-group">
					  <input type="radio" class="radio-inline" id="user_type" name="user_type" value="1"
					  <?php if( $sel_user['user_type'] == 1){echo ' checked';} ?>> Admin &nbsp;
					  <input type="radio" class="radio-inline" id="user_type" name="user_type" value="2"
					  <?php if( $sel_user['user_type'] == 2){echo ' checked';} ?>> Customer &nbsp;
					</div>					
					</div>
				  </div>				  
				  				  
					<center><h3>User Contact info.</h3></center>

				  <div class="form-group">
					<label for="user_job" class="col-sm-2 control-label">Job Title</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_job" name="user_job" required="" value="<?php echo $sel_user['job']; ?>">
					</div>
				  </div>				  
				  
				  <div class="form-group">
					<label for="user_address" class="col-sm-2 control-label">Full Address</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_address" name="user_address" required="" value="<?php echo $sel_user['address'] ?>">
					</div>
				  </div>				  
				  
				  <div class="form-group">
					<label for="user_phone" class="col-sm-2 control-label">Office Phone#</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_phone" name="user_phone" required="" value="<?php echo $sel_user['phone']; ?>">
					</div>
				  </div>	
				  
				  <div class="form-group">
					<label for="user_mobile" class="col-sm-2 control-label">Mob#</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_mobile" name="user_mobile" required="" value="<?php echo $sel_user['mobile']; ?>">
					</div>
				  </div>	
				  
				  <div class="form-group">
					<label for="user_fax" class="col-sm-2 control-label">Fax#</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="user_fax" name="user_fax" required="" value="<?php echo $sel_user['fax']; ?>">
					</div>
				  </div>
				
					
					<center><h3>User Company info.</h3></center>	
				  
				  <div class="form-group">
					<label for="company_name" class="col-sm-2 control-label">Company Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_name" name="company_name" required="" value="<?php echo $sel_user['company_name']; ?>">
					</div>
				  </div>	
				  
				  <div class="form-group">
					<label for="company_website" class="col-sm-2 control-label">Website</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_website" name="company_website" required="" value="<?php echo $sel_user['company_website']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_address" class="col-sm-2 control-label">Address</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_address" name="company_address" required="" value="<?php echo $sel_user['company_address']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_city" class="col-sm-2 control-label">City</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_city" name="company_city" required="" value="<?php echo $sel_user['company_city']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_state" class="col-sm-2 control-label">Stale</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_state" name="company_state" required="" value="<?php echo $sel_user['company_state']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_zip" class="col-sm-2 control-label">Zip</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_zip" name="company_zip" required="" value="<?php echo $sel_user['company_zip']; ?>">
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
								if($sel_user['company_country'] == $country){
									echo '<option selected="selected" value="'.$country .'">'.$country .'</option>';
								}else{
									echo '<option value="'.$country .'">'.$country .'</option>';
								}
							  }						
						?>
					  </select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_years" class="col-sm-2 control-label">Business Entry Years</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_years" name="company_years" required="" value="<?php echo $sel_user['company_years']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_started" class="col-sm-2 control-label">Business Established</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_started" name="company_started" required="" value="<?php echo $sel_user['company_started']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="company_tax" class="col-sm-2 control-label">Fedral Tax ID</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="company_tax" name="company_tax" required="" value="<?php echo $sel_user['company_tax']; ?>">
					</div>
				  </div>
					  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" name="update" class="btn btn-default">Update user</button>
				  <a class="btn btn-danger" href="<?php echo site_options('link'); ?>/admin/users_index.php">cancel</a>
					</div>
				  </div>
				  
				</form>
			</article>
		
	
	
		</div>

<?php require_once('../includes/footer.php'); ?>