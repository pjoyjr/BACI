<?php 

require_once "db_connect.php";

$stmt = $con->prepare("SELECT * FROM user_tbl WHERE userStatus = 1 AND active = 1");
$stmt->execute(array());

$string = <<<EOT
<table  id="mentorList" class="display table" cellspacing="0" width="100%">
<thead>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Gender</th>
<th>Age</th>
<th>Phone</th>
<th>Identity</th>
<th></th>
</tr>
</thead>
<tfoot>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Gender</th>
<th>Age</th>
<th>Phone</th>
<th>Identity</th>
<th></th>
</tr>
</tfoot>
EOT;

$curYear = date('Y');

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$gender = "";
	$identity = "";
	$birthYear = "";
	$age = "";

	if ($row["gender"] == 0)
		$gender = "Male";
	else
		$gender = "Female";

	if ($row["identityID"] == 0)
		$identity = "Student";
	else
		$identity = "Working Professional";

	$birthYear = $row["birthYear"];
	$age = $curYear - $birthYear;

	$string = $string."<tr><td>".$row["firstName"]."</td><td>".$row["lastName"]."</td><td>".$row["email"]."</td><td>".$gender."</td><td>".$age."</td><td>".$row["phone"]."</td><td>".$identity."</td><td><a href='userProfile.php?userID=".$row["ID"]."&mmSelect=0' class='btn btn-outline-info'>Mentor Profile</a></td></tr>";
}

print($string);