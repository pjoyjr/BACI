<?php 
include 'header.php';
include 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];

$userID = $user->getID();

$currentDir = getcwd();
$pictureDir = "/pics/";
$resumeDir = "/resume/";

$uploadPath = "";
$savePath = "";


$errors = array();

$picExtensions = array('jpeg', 'jpg', 'png');
$resumeExtensions = array('docx','doc','pdf','odt','txt');

$picName = "";
$picSize = "";
$picTmpName = "";
$picType = "";
$picExtension = "";

$msg = "";

if (isset($_FILES["picture"]["name"])) {
	if ($_FILES['picture']['size'] != 0) {
		$picName = $_FILES['picture']['name'];
		$picSize = $_FILES['picture']['size'];
		$picTmpName = $_FILES['picture']['tmp_name'];
		$picType = $_FILES['picture']['type'];
		$picExtension = strtolower(end(explode('.',$picName)));

		$uploadPath = $currentDir . $pictureDir . basename($picName) . $userID; 
		if (isset($_POST['submit'])) {

			if (! in_array($picExtension,$picExtensions)) {
				array_push($errors,  "This picture extension is not allowed. Please upload a JPEG or PNG file");
			}

			if ($picSize > 2000000) {
				array_push($errors, "This picture is more than 2MB. Sorry, it has to be less than or equal to 2MB");
			}

			if (empty($errors)) {
				$didUpload = move_uploaded_file($picTmpName, $uploadPath);

				if ($didUpload) {
					$savePath = $pictureDir . basename($picName) . $userID;
					$savePath = substr($savePath, 1);
					$msg = $msg."The picture " . basename($picName) . " has been uploaded\n";
					$stmt = $con->prepare('INSERT INTO picture_tbl (location) VALUES (:location)');
		        	$stmt->execute(array('location'=>$savePath));
		        	$user->setImagePath($savePath);
		        	$picture_id = $con->lastInsertId();
					$updateUserInfo = $con->prepare("UPDATE user_tbl SET pictureID = '$picture_id' WHERE ID = '$userID'");
					$updateUserInfo->execute(array());
				} else {
					$msg = $msg."An error occurred with uploading the Picture. Try again or contact the admin";
				}
			} else {
				foreach ($errors as $error) {
					echo $error."\n";
				}
			}
	    }
	}
}

if (isset($_FILES["resume"]["name"])) {
	if ($_FILES['resume']['size'] != 0) {
		$resumeName = $_FILES['resume']['name'];
		$resumeSize = $_FILES['resume']['size'];
		$resumeTmpName = $_FILES['resume']['tmp_name'];
		$resumeType = $_FILES['resume']['type'];
		$resumeExtension = strtolower(end(explode('.',$resumeName)));

		$uploadPath = $currentDir . $resumeDir . $userID. basename($resumeName); 
		if (isset($_POST['submit'])) {

			if (! in_array($resumeExtension,$resumeExtensions)) {
				array_push($errors,  "This resume extension is not allowed. Please upload a .docx, .doc, .pdf, .odt, or .txtfile file");
			}

			if ($picSize > 2000000) {
				array_push($errors, "This resume is more than 2MB. Sorry, it has to be less than or equal to 2MB");
			}

			if (empty($errors)) {
				$didUpload = move_uploaded_file($resumeTmpName, $uploadPath);

				if ($didUpload) {
					$savePath = $resumeDir . $userID . basename($resumeName);
					$savePath = substr($savePath, 1);
					$msg = $msg."The resume " . basename($resumeName) . " has been uploaded\n";
					$stmt = $con->prepare('INSERT INTO resume_tbl (location) VALUES (:location)');
		        	$stmt->execute(array('location'=>$savePath));
		        	$user->setResumePath($savePath);
		        	$resume_id = $con->lastInsertId();
					$updateUserInfo = $con->prepare("UPDATE user_tbl SET resumeID = '$resume_id' WHERE ID = '$userID'");
					$updateUserInfo->execute(array());
				} else {
					$msg = $msg."An error occurred with uploading the Resume. Try again or contact the admin";
				}
			} else {
				foreach ($errors as $error) {
					echo $error."\n";
				}
			}
	    }
	}
}


?>

<section id="editUserInfo">
	<div id="userInfoCell">
		<div class="container">
			<div class="row mt-4">
				<div class="col-md-4 col-sm-4">
					<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<h2>Upload Files</h2>
					<p class="lead"><?php echo $msg; ?></p>
				</div>
			</div>
			<form action="fileUpload.php" method="post" enctype="multipart/form-data">
				<div class="row mt-5">
					<div class="col-lg-6 col-sm-12">
						<span class="help-block">
							<h4>Upload Picture</h4>
						</span>
						<div class="input-group">
							<label class="input-group-btn">
								<span class="btn btn-primary sharp">
									Browse&hellip; <input type="file" style="display: none;" accept="image/*" name="picture">
								</span>
							</label>
							<input type="text" class="form-control" readonly>
						</div>
					</div>
					<div class="col-lg-6 col-sm-12">
						<span class="help-block">
							<h4>Upload Resume</h4>
						</span>
						<div class="input-group">
							<label class="input-group-btn">
								<span class="btn btn-primary sharp">
									Browse&hellip; <input type="file" style="display: none;" accept=".docx,.doc,.pdf,.odt,.txt" name="resume">
								</span>
							</label>
							<input type="text" class="form-control" readonly>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-sm-2 offset-sm-10">
						<button type="submit" class="btn btn-success btn-block" name="submit" value="submit">Upload <i class="fas fa-cloud-upload-alt"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<?php 
include 'footer.php';
?>