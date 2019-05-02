<?php 
include 'header.php';
include 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];

$userPage = "";
if (isset($_REQUEST['id']))
	$userPage = $_REQUEST['id'];

$userID = $user->getID();
$userPriv = $user->getUserPrivilege();

if ($userID != $userPage && $userPriv == 0)
	header('Location: dashboard.php'); 
if ($userID != $userPage) {
	$profileStmt = $con->prepare('SELECT * FROM user_tbl WHERE ID = :ID');
	$profileStmt->execute(array('ID'=>$userPage));
	$row = $profileStmt->fetch(PDO::FETCH_OBJ);
	if($profileStmt->rowCount() != 1) {
		$msg = "Profile Not Found";
	} else {
		$user = new User();
		$user->setID($row->ID);
		$user->setFbLink($row->fbLink);
		$user->setTwLink($row->twLink);
		$user->setLkLink($row->firstName);

		$userID = $user->getID();
	}
}


$fbLink= "";
$twLink= "";
$lkLink = "";

$success = "";

if (isset($_POST['update'])) {
	
	$fbLink = trim($_POST['fbLink']);
	$twLink = trim($_POST['twLink']);
	$lkLink = trim($_POST['lkLink']);
	echo "<h3>".$userID."</h3>";
	
	$updateUserInfo = $con->prepare("UPDATE user_tbl SET fbLink = '$fbLink', twLink = '$twLink', lkdLink = '$lkLink' WHERE ID = '$userID'");
	$updateUserInfo->execute(array());
	$user->setFbLink($fbLink);
	$user->setTwLink($twLink);
	$user->setLkLink($lkLink);

	$success = "Update Successful";

}
?>

<section id="editUserInfo">
	<div id="userInfoCell">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-8">
					<h4>Edit Additional Information</h4>
				</div>
				<div class="col-md-8 col-sm-12">
					<p class="lead">Click the information you wish to edit</p>
				</div>
			</div>
			<form action="editAdditionalInfo.php?id=<?php echo $user->getID(); ?>" method="post">
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Facebook Link: </p>
					</div>
					<div class="col-md-8 col-sm-12">Facebook.com/
						<input type="text" class="form-control editUser" id="fbLink" name="fbLink" value="<?php echo($user->getFbLink()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Twitter Link:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">Twitter.com/
						<input type="text" class="form-control editUser" id="twLink" name="twLink" value="<?php echo($user->getTwLink()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">LinkedIn Link:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">LinkedIn.com/
						<input type="text" class="form-control editUser" id="lkLink" name="lkLink" value="<?php echo($user->getLkLink()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<a href="userProfile.php?userID=<?php echo $userID; ?>" class="btn btn-secondary btn-sm">Back to User Profile <i class="fas fa-undo-alt"></i></a>
					</div>
					<div class="form-group col-sm-12 col-md-8">
						<button type="submit" class="btn btn-dark btn-sm" name="update">Update <i class="fas fa-cloud-upload-alt"></i></button>
						<?php echo $success; ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<?php 
include 'footer.php';
?>