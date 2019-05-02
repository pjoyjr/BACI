<?php 
include 'header.php';
include 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];

$msg = "Change Password";

$userID = $user->getID();

$currentPasswordMsg = "";
$confirmNewPasswordMsg = "";

if (isset($_POST['update'])) {

	$currentPassword = trim($_POST['currentPassword']);
	$newPassword = trim($_POST['newPassword']);
	$confirmNewPassword = trim($_POST['confirmNewPassword']);

	if ($newPassword != $confirmNewPassword)
		$confirmNewPasswordMsg = '<span style="color:red">Does Not Match</span>';
	else if ($currentPassword != $user->getPassword())
		$currentPasswordMsg = '<span style="color:red">Incorrect Password</span>';
	else {
		$updatePassword = $con->prepare("UPDATE user_tbl SET password = '$newPassword' WHERE ID = '$userID'");
		$updatePassword->execute(array());
		$user->setPassword($newPassword);
		$msg = "Password Successfully Changed";
	}
}

?>

<section id="loginPage">

	<div id="login">
		<div id="loginForm">
			<h3><?php echo $msg; ?></h3>
			<form action="changePassword.php" method="post">
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm New Password" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<button type="submit" class="btn btn-light btn-sm" name="update">Update <i class="fas fa-cloud-upload-alt"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>