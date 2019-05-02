<?php 
include 'header.php';
include 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$eduID = $_GET['num'];

$eduSTMT = $con->prepare('SELECT * FROM education_tbl WHERE ID = :ID');
$eduSTMT->execute(array('ID'=>$eduID));
$eduRow = $eduSTMT->fetch(PDO::FETCH_OBJ);

$degree = $eduRow->degreeType;
$major = $eduRow->major;
$schoolName = $eduRow->schoolName;
$completionYear = $eduRow->completionYear;

$success = "";

if (isset($_POST['update'])) {
	
	$degree = trim($_POST["degree"]);
	$major = trim($_POST["major"]);
	$schoolName = trim($_POST["school"]);
	$completionYear = trim($_POST["yearCompleted"]);
	
	$updateEduInfo = $con->prepare("UPDATE education_tbl SET degreeType = '$degree', major = '$major', schoolName = '$schoolName', completionYear = '$completionYear' WHERE ID = '$eduID'");
	$updateEduInfo->execute(array());
	// $user->setFirstName($firstName);
	// $user->setLastName($lastName);
	// $user->setEmail($email);
	// $user->setGender($gender);
	// $user->setPhoneNumber($phoneNumber);
	// $user->setUserStatus($userStatus);

	$success = "Update Successful";

}
?>

<section id="editUserInfo">
	<div id="userInfoCell">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-8">
					<h4>Edit Education Information</h4>
				</div>
				<div class="col-md-8 col-sm-12">
					<p class="lead">Click the information you wish to edit</p>
				</div>
			</div>
			<form action="editEducation.php?num=<?php echo($eduID) ?>" method="post">
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Degree Type</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<?php 
						$stmt = $con->prepare("SELECT * FROM degree_tbl WHERE active = 1");
						$stmt->execute(array());

						print "<select id='degree'class='form-control' name='degree' required>";
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							if ($row['ID'] == $degree)
								print "<option value='" . $row['ID'] ."' selected>" . $row['type'] ."</option>";
							else
								print "<option value='" . $row['ID'] ."'>" . $row['type'] ."</option>";
						}
						print("</select>");

						?>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Major</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="major" name="major" value="<?php echo $major; ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">School Name</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="school" name="school" value="<?php echo($schoolName); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Completion Year</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<select id="yearCompleted" class="form-control yearDropdown" name="yearCompleted" required> 			
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<a href="userProfile.php" class="btn btn-secondary btn-sm">Back to User Profile <i class="fas fa-undo-alt"></i></a>
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