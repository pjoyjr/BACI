<?php echo $msg; ?>
<?php if ($formType == 1) { ?>
<form action="registration.php" method="post">
<?php } else if ($formType == 2) { ?>
<form action="addUser.php" method="post">
<?php } ?>
	<?php if ($formType == 2) { ?>
	<div class="form-row">
		<div class="form-group col-sm-12 col-md-6">
			<label for="userType">User Type</label>
			<select id="userType" class="form-control" name="userType">
				<option value="0" selected>User</option>
				<option value="1">Coordinator</option>
				<?php if ($priv == 3) { ?>
				<option value="2">Admin</option>
				<?php } ?>					
			</select>
		</div>
	</div>
	<?php } ?>
	<div class="form-row">
		<div class="form-group col-md-6 col-sm-12">
			<label for="userName">User Name <?php echo $userNameReq; ?></label>
			<input type="text" class="form-control" id="userName" value="<?php print $userName; ?>" name="userName" required="Please Enter A UserName">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6 col-sm-12">
			<label for="firstName">First Name <?php echo $firstNameReq; ?></label>
			<input type="text" class="form-control" id="firstName" value="<?php print $firstName; ?>" required="Please Enter A First Name" name="firstName">
		</div>
		<div class="form-group col-md-6 col-sm-12">
			<label for="lastName">Last Name <?php echo $lastNameReq; ?></label>
			<input type="text" class="form-control" id="lastName" value="<?php print $lastName; ?>" required="Please Enter A Last Name" name="lastName">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6 col-sm-12">
			<label for="email">Email <?php echo $emailReq; ?></label>
			<input type="email" class="form-control" id="email" value="<?php print $email; ?>" required="Please Enter An Email" name="email">
		</div>
		<div class="form-group col-md-6 col-sm-12">
			<label for="confirmEmail">Confirm Email <?php echo $confirmEmailReq; ?></label>
			<input type="email" class="form-control" id="confirmEmail" value="<?php print $confirmEmail; ?>" required="Please Confirm Email" name="confirmEmail">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6 col-sm-12">
			<label for="password">Password <?php echo $passwordReq; ?></label>
			<input type="password" class="form-control" id="password" required="Please Enter A Password" name="password">
		</div>
		<div class="form-group col-md-6 col-sm-12">
			<label for="confirmPassword">Confirm Password <?php echo $confirmPasswordReq; ?></label>
			<input type="password" class="form-control" id="confirmPassword" required="Please Confirm Password" name="confirmPassword">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-3 col-sm-6">
			<label for="phoneNumber">Phone Number</label>
			<input type="tele" class="form-control" id="phoneNumber" value="<?php print $phoneNumber; ?>" name="phoneNumber">
		</div>
		<div class="form-group col-md-3 col-sm-6">
			<label for="gender">Gender</label>
			<select id="gender" class="form-control" name="gender">
				<option value="0" selected>Male</option>
				<option value="1">Female</option>				
			</select>
		</div>
		<div class="form-group col-md-3 col-sm-6">
			<label for="birthYear">Birth Year</label>
			<select name="birthYear" id="birthYear" class="form-control"></select>
		</div>
		<div class="form-group col-md-3 col-sm-6">
			<label for="userStatus">User Status</label>
			<select id="userStatus" class="form-control" name="userStatus">
				<option value="0" selected>Mentee</option>
				<option value="1">Mentor</option>
				<option value="2">Neither</option>					
			</select>
		</div>
	</div>
	<hr>
	<div class="form-row">
		<div class="form-group col-md-6 col-sm-12">
			<label for="address1">Address</label>
			<input type="text" class="form-control" id="address1" value="<?php print $address1; ?>" name="address1">
		</div>
		<div class="form-group col-md-6 col-sm-12">
			<label for="address2">Address 2</label>
			<input type="text" class="form-control" id="address2" value="<?php print $address2; ?>" name="address2">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-3 col-sm-6">
			<label for="country">Country</label>
			<select id="country" class="form-control" name="country">
				<option selected="" disabled="">Select Country</option>
			<?php 
			require_once 'data.php';
			$countries = loadCountries($con);
			foreach ($countries as $country) {
				echo "<option value='".$country['ID']."'>".$country['name']."</option>";
			}
			// $resultCountry = $con->query("select * from country_tbl where active = 1 ORDER BY name ASC");
			// echo '<select id="country" class="form-control" name="country">';
			// while($rowCountry = $resultCountry->fetch(PDO::FETCH_ASSOC)) {
			// 	echo "<option value='" . $rowCountry['ID'] ."'>" . $rowCountry['name'] ."</option>";
			// }
			// echo "</select>";
			?>
			</select>
		</div>
		<div class="form-group col-md-3 col-sm-6">
			<label for="state">State/Province</label>
			<select id="state" class="form-control" name="state">
				<option selected="" disabled="">Select State</option>
			<?php 
			// $resultState = $con->query("select * from state_tbl WHERE active = 1 ORDER BY name ASC");
			// echo '<select id="state" class="form-control" name="state">';
			// while($rowState = $resultState->fetch(PDO::FETCH_ASSOC)) {
			// 	echo "<option value='" . $rowState['ID'] ."'>" . $rowState['name'] ."</option>";
			// }
			// echo "</select>";
			?>
			</select>
		</div>
		<div class="form-group col-md-4 col-sm-8">
		<label for="city">City</label>
		<input type="text" class="form-control" id="city" value="<?php print $city; ?>" name="city">
		</div>
		<div class="form-group col-md-2 col-sm-4">
			<label for="zip">Zip Code</label>
			<input type="text" class="form-control" id="zip" value="<?php print $zip; ?>" name="zip">
		</div>
	</div>
	<hr>
	<div class="form-row">
		<div class="form-group col-md-3 col-sm-6">
			<button type="button" class="btn btn-success" id="addEducation">Add Education</button>
		</div>
		<div class="form-group col-md-3 col-sm-6">
			<button type="button" class="btn btn-danger" id="removeEducation">Remove Education</button>
		</div>
	</div>
	<div id="dynamicEducation"></div>
	<hr>
	<div class="form-row">
		<div class="form-group col-md-4 col-sm-8">
			<label for="employment">Student/Working Professional</label>
			<select id="employment" class="form-control" name="employment">
				<option value="student" selected>Student</option>
				<option value="workingProfessional">Working Professional</option>				
			</select>
		</div>
		<div class="form-group col-md-4 col-sm-8 workingProfessional">
			<label for="field">Field</label>
			<input type="text" class="form-control" id="field" name="field">
		</div>
		<div class="form-group col-md-4 col-sm-8 workingProfessional">
			<label for="employer">Employer</label>
			<input type="text" class="form-control" id="employer" name="employer">
		</div>
	</div>
	<hr>
	<div class="form-row">
		<div class="form-group col-sm-6 col-md-4 ">
			<label for="fbLink">Facebook.com/
			<input type="text" class="form-control" id="fbLink" value="<?php print $fbLink; ?>"  name="fbLink"></label>
		</div>
		<div class="form-group col-sm-6 col-md-4 ">
			<label for="twLink">Twitter.com/
			<input type="text" class="form-control" id="twLink" value="<?php print $twLink; ?>" name="twLink">
		</div>
		<div class="form-group col-sm-6 col-md-4 ">
			<label for="lkdLink">LinkedIn.com/
			<input type="text" class="form-control" id="lkdLink" value="<?php print $lkdLink; ?>" name="lkdLink"></label>
		</div>
	</div>
	<?php 
	if($formType == 1) { ?>
	<div>
		<input type="checkbox" name="tos"> <?php print $tosre; ?> By clicking Register, you agree to our Terms, Data Policy and Cookies Policy.</br></br>
	</div>
	<?php } ?>
	<button type="submit" class="btn btn-primary" name="enter">Register</button>
</form>