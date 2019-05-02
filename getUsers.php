<?php 

require_once "db_connect.php";

require_once 'userClass.php';
session_start();
$userPriv = $_SESSION['user']->getUserPrivilege();
if($userPriv == 2 || $userPriv == 3)
	$stmt = $con->prepare('SELECT * FROM user_tbl');
else
	$stmt = $con->prepare('SELECT * FROM user_tbl WHERE active = 1');
$stmt->execute(array());


$stmtCountry = $con->prepare('SELECT * FROM country_tbl');

$string = <<<EOT
<table  id="userList" class="display table" cellspacing="0" width="110%">
<thead>
<tr>
<th></th>
<th>Name</th>
<th>Email</th>
<th>Gender</th>
<th>Age</th>
<th>State</th>
<th>Country</th>
<th>Identity</th>
<th>Education Level</th>
<th>Preference</th>
<th>Status</th>
<th>Registered</th>
</tr>
</thead>
<tfoot>
<tr>
<th></th>
<th>Name</th>
<th>Email</th>
<th>Gender</th>
<th>Age</th>
<th>State</th>
<th>Country</th>
<th>Identity</th>
<th>Education Level</th>
<th>Preference</th>
<th>Status</th>
<th>Registered</th>
</tr>
</tfoot>
EOT;

$curYear = date('Y');

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	if($userPriv > $row["privilege"]){
		$gender = "";
		$birthYear = "";
		$identity = "";
		$userStatus = "";

		if ($row["gender"] == 0)
			$gender = "Male";
		else
			$gender = "Female";

		if ($row["identityID"] == 0){
			$identity = "Student";
		}else{
			$identity = "Working Professional";
			$idID = $row["identityID"];
			$stmtID = $con->prepare('SELECT * FROM identity_tbl WHERE ID = :id');
			$stmtID->execute(array('id' => $idID));
			$rowID = $stmtID->fetch(PDO::FETCH_ASSOC);
		}

		$addressID = $row["addressID"];
		$stmtAddress = $con->prepare('SELECT * FROM address_tbl WHERE ID = :id');
		$stmtAddress->execute(array('id' => $addressID));
		$rowAddress = $stmtAddress->fetch(PDO::FETCH_ASSOC);
		$stateID = $rowAddress["stateID"];

		$stmtState = $con->prepare('SELECT * FROM state_tbl WHERE ID = :id');
		$stmtState->execute(array('id' => $stateID));
		$rowState = $stmtState->fetch(PDO::FETCH_ASSOC);
		$state = $rowState["name"];
		$countryID = $rowState["countryID"];

		$stmtCountry = $con->prepare('SELECT * FROM country_tbl WHERE ID = :id');
		$stmtCountry->execute(array('id' => $countryID));
		$rowCountry = $stmtCountry->fetch(PDO::FETCH_ASSOC);
		$country = $rowCountry["name"];

		$stmtEdu = $con->prepare('SELECT * FROM education_tbl WHERE userID = :id');
		$stmtEdu->execute(array('id' => $row["ID"]));
		$rowEdu = $stmtEdu->fetch(PDO::FETCH_ASSOC);
		$degreeType = $rowEdu["degreeType"];

		$stmtEdu2 = $con->prepare('SELECT * FROM degree_tbl WHERE ID = :id');
		$stmtEdu2->execute(array('id' => $degreeType));
		$rowEdu2 = $stmtEdu2->fetch(PDO::FETCH_ASSOC);
		$degree = $rowEdu2["type"];
		if($degree == "")
			$degree = "n/a";

		$birthYear = $row["birthYear"];
		$age = $curYear - $birthYear;
		$statusUser = $row["userStatus"];
		if($statusUser == 0)
			$userStatus = "Mentee";
		if($statusUser == 1)
			$userStatus = "Mentor";
		if($statusUser == 2)
			$userStatus = "Niether";
		
		if($row['active'] == 2)
		$status = "Deleted";
		if($row['active'] == 1)
		$status = "Active";
		if($row['active'] == 0)
		$status = "Inactive";
		
		
		$string = $string."<tr><td><a href='userProfile.php?userID=".$row["ID"]."' class='btn btn-outline-info'>View</a></td><td>".$row["firstName"]." ".$row["lastName"]."</td>";
		$string = $string."<td>".$row["email"]."</td><td>".$gender."</td><td>".$age."</td><td>".$state."</td><td>".$country."</td><td>".$identity."</td><td>".$degree."</td>";
		$string = $string."<td>".$userStatus."</td><td>".$status."</td><td>".$row["registerDate"]."</td></tr>";
	}
}
print($string);