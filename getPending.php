<?php 
require_once "db_connect.php";
$stmt = $con->prepare("SELECT * FROM mmRelationship_tbl WHERE rejectDate IS NULL AND startDate IS NULL");
$stmt->execute(array());
$string = <<<EOT
<table  id="userList" class="display table" cellspacing="0" width="100%">
<thead>
<tr>
<th>Mentor Full Name</th>
<th>Mentor ID</th>
<th>Mentee Full Name</th>
<th>Mentee ID</th>
<th>Requester</th>
<th>Request Date</th>
<th></th>
<th></th>
</tr>
</thead>
<tfoot>
<tr>
<th>Mentor Full Name</th>
<th>Mentor ID</th>
<th>Mentee Full Name</th>
<th>Mentee ID</th>
<th>Requester</th>
<th>Request Date</th>
<th></th>
<th></th>
</tr>
</tfoot>
EOT;
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$mentorFullName = "";
	$menteeFullName = "";
	$requester = "";
	$mentorStmt = $con->prepare("SELECT * FROM user_tbl WHERE ID = :ID");
	$mentorStmt->execute(array('ID'=>$row["mentorID"]));
	$mentorRow = $mentorStmt->fetch(PDO::FETCH_ASSOC);
	$mentorFullName = $mentorRow["firstName"]." ".$mentorRow["lastName"];
	$menteeStmt = $con->prepare("SELECT * FROM user_tbl WHERE ID = :ID");
	$menteeStmt->execute(array('ID'=>$row["menteeID"]));
	$menteeRow = $menteeStmt->fetch(PDO::FETCH_ASSOC);
	$menteeFullName = $menteeRow["firstName"]." ".$menteeRow["lastName"];
	if($row["requester"] == 0)
		$requester = "Mentee";
	else if ($row["requester"] == 1)
		$requester = "Mentor";
	else
		$requester = "Coordinator";

	if ($mentorRow['active'] == 1 && $menteeRow['active'] == 1) {
		$string = $string."<tr><td>".$mentorFullName."</td><td>".$row["mentorID"]."</td><td>".$menteeFullName."</td><td>".$row["menteeID"]."</td><td>".$requester."</td><td>".$row["requestDate"]."</td><td><a href='pairing.php?mentor=".$row["mentorID"]."&mentee=".$row["menteeID"]."&change=1' class='btn btn-outline-success'>Approve Pairing</a></td><td><a href='pairing.php?mentor=".$row["mentorID"]."&mentee=".$row["menteeID"]."&change=0' class='btn btn-outline-danger'>Deny Pairing</a></td></tr>";
	}
}
print($string);