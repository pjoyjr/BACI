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
$country = "";

//add to database
if(isset($_POST['add'])) {
	$newCountry = trim($_POST['addCountry']);
	if($newCountry != ""){
		$stmt = $con->prepare('INSERT INTO country_tbl (ID, name, active) VALUES (Null, :country, 1)');
		$stmt->execute(array('country' => $newCountry));
	}
}

//edit from database
if(isset($_POST['edit'])){
		$countryNum = trim($_POST['countryNameEdit']);
		$country = trim($_POST['editCountry']);
		if($country != ""){
			$stmt = $con->prepare('UPDATE country_tbl SET name = :name WHERE ID = :num');
			$stmt->execute(array('name' => $country, 'num' => $countryNum));
		}
	}	

//activate in database
if(isset($_POST['activate'])){
		$countryNum = trim($_POST['countryNum']);
		$stmt = $con->prepare('UPDATE country_tbl SET active = 1 WHERE ID = :num');
		$stmt->execute(array('num' => $countryNum));
	}		
	
//deactivate in database
if(isset($_POST['deactivate'])){
		$countryNum = trim($_POST['countryNum']);
		$stmt = $con->prepare('UPDATE country_tbl SET active = 0 WHERE ID = :num');
		$stmt->execute(array('num' => $countryNum));
	}	
	
$result = $con->query("select * from country_tbl WHERE active = 1 ORDER BY name ASC");	
$result2 = $con->query("select * from country_tbl WHERE active = 0 ORDER BY name ASC");	
?>

<div class="container" id="configureCountry">
	<section id="blankHeader">
		<div class="row mt-4">
			<div class="col-sm-12">
				<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-sm-6 col-md-4" style="padding-right:20px; border-right: 1px solid #ccc;">
				<!-- PRINT ALL COUNTRIES-->
				<h4>List of active countries in database are:</h4>
				<?php 
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					echo $row["name"] . "<br>";
				} ?>
				</br></br>
				<h4>List of inactive countries in database are:</h4>
				<?php 
				while($row = $result2->fetch(PDO::FETCH_ASSOC)) {
					echo $row["name"] . "<br>";
				} ?>
			</div>
			<div class="col-sm-6 col-md-8">
			<!-- ADD COUNTRY TO DATABASE-->
				<div class="row">
					<div class="col-sm-12">
						<h4>Add Country</h4>
						<form action="configureCountry.php" method="post">
							<div class="input-group mb-3">
								<input type="text" class="form-control" name="addCountry">
								<div class="input-group-append">
									<button type="submit" class="btn btn-success" name="add">Add Country</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- EDIT COUNTRY IN DATABASE-->
				<div class="row mt-2">
					<div class="col-sm-12">
						<h4>Edit Country</h4>
						<form action="configureCountry.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="countryNameEdit">Countries</label>
								</div>
								<select class="custom-select" name="countryNameEdit">
									<?php
									$result1 = $con->query("select * from country_tbl ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['name']."</option>";
									}
									?>
								</select>
								<input type="text" class="form-control" name="editCountry">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary" name="edit">Edit Country</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- ACTIVATE COUNTRY IN DATABASE-->
				<div class="row mt-2">
					<div class="col-sm-12">
						<h4>Activate Country</h4>
						<form action="configureCountry.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="countryNum">Countries</label>
								</div>
								<select class="custom-select" name="countryNum">
									<?php
									$result1 = $con->query("select * from country_tbl WHERE active = 0 ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['name']."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-success" name="activate">Activate Country</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				<!-- DEACTIVATE COUNTRY IN DATABASE-->
				<div class="row mt-2">
					<div class="col-sm-12">
						<h4>Deactivate Country</h4>
						<form action="configureCountry.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="countryNum">Countries</label>
								</div>
								<select class="custom-select" name="countryNum">
									<?php
									$result1 = $con->query("select * from country_tbl WHERE active = 1 ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['name']."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-danger" name="deactivate">Deactivate Country</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
	</section>
	
</div>
