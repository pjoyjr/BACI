<?php 
require_once 'db_connect.php';
include 'userClass.php';
session_start();
$stmt = $con->prepare('SELECT * FROM user_tbl WHERE active = 1');
$stmt->execute(array());

$stmtCountry = $con->prepare('SELECT * FROM country_tbl');

$string = <<<EOT
<table  id="userList" class="display table" cellspacing="0" width="110%">
<thead>
<tr>
<th></th>
<th>Name</th>
<th>Privileges>
<th>Email</th>
<th>Gender</th>
<th>Age</th>
<th>State</th>
<th>Country</th>
<th>Identity</th>
<th>Education Level</th>
<th>Registered</th>
</tr>
</thead>
<tfoot>
<tr>
<th></th>
<th>Name</th>
<th>Privileges>
<th>Email</th>
<th>Gender</th>
<th>Age</th>
<th>State</th>
<th>Country</th>
<th>Identity</th>
<th>Education Level</th>
<th>Registered</th>
</tr>
</tfoot>
EOT;

$curYear = date('Y');

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	if($row["privilege"] < $_SESSION['user']->getUserPrivilege()){
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
		
		if($row["privilege"] == 2)
			$priv = "Admin";
		if($row["privilege"] == 1)
			$priv = "Coordinator";
		if($row["privilege"] == 0)
			$priv = "User";

		$string = $string."<tr><td><a href='hideUser.php?userID=".$row["ID"]."' class='btn btn-outline-danger'>Deactivate</a></td><td>".$row["firstName"]." ".$row["lastName"]."</td><td>".$priv."</td>";
		$string = $string."<td>".$row["email"]."</td><td>".$gender."</td><td>".$age."</td><td>".$state."</td><td>".$country."</td><td>".$identity."</td><td>".$degree."</td><td>".$row["registerDate"]."</td></tr>";

	}
}
print($string);