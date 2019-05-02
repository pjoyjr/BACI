<?php 
require_once 'header.php';
require_once "db_connect.php";
			
//verify logged in as a admin
$user = $_SESSION['user'];
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}
$userPriv = $user->getUserPrivilege();
if($userPriv < 1 || $userPriv > 3){
	header('Location: dashboard.php');
}			
	
//initialize variable
$degree = "";

//add to database
if(isset($_POST['add'])) {
	$newDegree = trim($_POST['addDegree']);
	if($newDegree != ""){
		$stmt = $con->prepare('INSERT INTO degree_tbl (ID, type, active) VALUES (Null, :degree, 1)');
		$stmt->execute(array('degree' => $newDegree));
	}
}

//edit in database
if(isset($_POST['edit'])){
		$degreeNum = trim($_POST['degreeNameEdit']);
		$degree = trim($_POST['editDegree']);
		if($degree != ""){
			$stmt = $con->prepare('UPDATE degree_tbl SET type = :name WHERE ID = :num');
			$stmt->execute(array('name' => $degree, 'num' => $degreeNum));
		}
	}	

//activate in database
if(isset($_POST['activate'])){
		$degreeNum = trim($_POST['degreeNum']);
		$stmt = $con->prepare('UPDATE degree_tbl SET active = 1 WHERE ID = :num');
		$stmt->execute(array('num' => $degreeNum));
	}		
	
//deactivate in database
if(isset($_POST['deactivate'])){
		$degreeNum = trim($_POST['degreeNum']);
		$stmt = $con->prepare('UPDATE degree_tbl SET active = 0 WHERE ID = :num');
		$stmt->execute(array('num' => $degreeNum));
	}				
	
$result = $con->query("select * from degree_tbl WHERE active = 1 ORDER BY type ASC");	
$result2 = $con->query("select * from degree_tbl WHERE active = 0 ORDER BY type ASC");	
?>

<div class="container" id="configureDegree">
	<section id="blankHeader">
		<div class="row mt-4">
			<div class="col-sm-12">
				<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-sm-6 col-md-4" style="padding-right:20px; border-right: 1px solid #ccc;">
				<!-- PRINT ALL Degrees-->
				<h4>List of active degrees in database are:</h4>
				<?php 
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					echo $row["type"] . "</br>";
				} ?>
				</br></br>
				<h4>List of inactive degrees in database are:</h4>
				<?php 
				while($row = $result2->fetch(PDO::FETCH_ASSOC)) {
					echo $row["type"] . "</br>";
				} ?>
			</div>
			<div class="col-sm-6 col-md-8">
				<!-- Add a Degree-->
				<div class="row">
					<div class="col-sm-12">
						<h4>Add Degree</h4>
						<form action="configureDegree.php" method="post">
							<div class="input-group mb-3">
								<input type="text" class="form-control" name="addDegree">
								<div class="input-group-append">
									<button type="submit" class="btn btn-success" name="add">Add Degree</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				<!-- Edit a Degree-->
				<div class="row mt-2">
					<div class="col-sm-12">
						<h4>Edit Degree</h4>
						<form action="configureDegree.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="degreeNameEdit">Degrees</label>
								</div>
								<select class="custom-select" name="degreeNameEdit">
									<?php
									$result1 = $con->query("select * from degree_tbl ORDER BY type ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['type']."</option>";
									}
									?>
								</select>
								<input type="text" class="form-control" name="editDegree">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary" name="edit">Edit Degree</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				<!-- Reactivate a Degree-->
				<div class="row mt-2">
					<div class="col-sm-12">
						<h4>Reactivate Degree</h4>
						<form action="configureDegree.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="degreeNameRemove">Degrees</label>
								</div>
								<select class="custom-select" name="degreeNum">
									<?php
									$result1 = $con->query("select * from degree_tbl WHERE active = 0 ORDER BY type ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['type']."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-success" name="activate">Activate Degree</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				<!-- Deactivate a Degree-->
				<div class="row mt-2">
					<div class="col-sm-12">
						<h4>Deactivate Degree</h4>
						<form action="configureDegree.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="degreeNameRemove">Degrees</label>
								</div>
								<select class="custom-select" name="degreeNum">
									<?php
									$result1 = $con->query("select * from degree_tbl  WHERE active = 1 ORDER BY type ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['type']."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-danger" name="deactivate">Deactivate Degree</button>
								</div>
							</div>
						</form>
					</div>
				</div>
								
			</div>
		</div>
		
	</section>
	
</div>
