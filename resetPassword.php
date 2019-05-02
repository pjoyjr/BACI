<?php

require_once 'header.php';
require_once 'db_connect.php';

//initializing variables

$code = ($_GET["code"]); //code from URL
	
$msg = "Enter new password:"; //message to user

$password = ""; //hold password for storing

if ((isset($_POST['submit'])) and ($code != "1")){
	
	$password = ($_POST['password']);
	
	$stmtPassword = $con->prepare("UPDATE user_tbl SET password = :password WHERE activationURL = :code");
	$stmtPassword -> execute(array('password' => $password, 'code' => $code));
	
	$msg = "Password Changed";

	$stmtURL = $con->prepare("UPDATE user_tbl SET activationURL = '1' WHERE activationURL = :code");
	$stmtURL -> execute(array('code' => $code));
}


?>

<section id="loginPage">

	<div id="login">
		<div id="loginForm">
			<h3><?php echo $msg; ?></h3>
			<form action="resetPassword.php" method="post">
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<button type="submit" class="btn btn-light btn-sm" name="submit">Update <i class="fas fa-cloud-upload-alt"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>
