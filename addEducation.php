<?php include 'header.php';
require_once 'db_connect.php'; 

$user = $_SESSION['user'];

$msg = "Add Education";

if (isset($_POST['submit'])) {
	$degree = array();
	$major = array();
	$school = array();
	$yearCompleted = array();
	$eduNum = 1;
	while (isset($_POST["degree".$eduNum])) {
		array_push($degree, trim($_POST["degree".$eduNum]));
		array_push($major, trim($_POST["major".$eduNum]));
		array_push($school, trim($_POST["school".$eduNum]));
		array_push($yearCompleted, trim($_POST["yearCompleted".$eduNum]));
		$eduNum++;
	}

	$stmtEdu = $con->prepare("INSERT INTO education_tbl (degreeType, major, schoolName, completionYear, userID) VALUES (:degree, :major, :school, :yearCompleted, :userID)");
	while(!empty($degree)) {
		$stmtEdu->execute(array('degree'=>array_pop($degree), 'major'=>array_pop($major), 'school'=>array_pop($school),  'yearCompleted'=>array_pop($yearCompleted), 'userID'=>$user->getID()));
	}

	$msg = "Successfully Added Education";
}
?>

<div class="container" id="registration">
	<section id="registrationHeader">
		<h2><?php echo $msg; ?></h2>
	</section>

	<form action="addEducation.php" method="post">
		<div class="form-row">
			<div class="form-group col-md-3 col-sm-6">
				<button type="button" class="btn btn-success" id="addEducation">Add Education</button>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<button type="button" class="btn btn-danger" id="removeEducation">Remove Education</button>
			</div>
		</div>
		<div id="dynamicEducation"></div>
		<button type="submit" class="btn btn-primary" name="submit">Submit</button>
	</form>
 
</div>

<?php include 'footer.php'; ?>