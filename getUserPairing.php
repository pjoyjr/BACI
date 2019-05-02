<?php
require_once "db_connect.php";

$pairStatus = $con->prepare('SELECT * FROM mmRelationship_tbl WHERE mentorID = :ID OR menteeID = :ID');
$pairStatus->execute(array('ID'=>$user->getID()));

$mentee = false;
$mentor = false;

$string = <<<EOT
<table  id="userList" class="display table" cellspacing="0" width="100%">
<thead>
<tr>
<th scope="col">Mentor Name</th>
<th scope="col">Mentee Name</th>
<th scope="col">Requester</th>
<th scope="col">Status</th>
<?php if ($status == 'Current') { ?>
<th scope="col">Start Date</th>
<?php } else if ($status == 'Pending') { ?>
<th scope="col">Request Date</th>
<?php } else if ($status == 'Rejected') {?>
<th scope="col">Reject Date</th>
<?php } else if ($status == 'Ended') {?>
<th scope="col">End Date</th>
<?php } ?>
<th scope="col">Actions</th>
<th scope="col"></th>
</tr>
</thead>
<tfoot>
<tr>
<th scope="col">Mentor Name</th>
<th scope="col">Mentee Name</th>
<th scope="col">Requester</th>
<th scope="col">Status</th>
<?php if ($status == 'Current') { ?>
<th scope="col">Start Date</th>
<?php } else if ($status == 'Pending') { ?>
<th scope="col">Request Date</th>
<?php } else if ($status == 'Rejected') {?>
<th scope="col">Reject Date</th>
<?php } else if ($status == 'Ended') {?>
<th scope="col">End Date</th>
<?php } ?>
<th scope="col">Actions</th>
<th scope="col"></th>
</tr>
</tfoot>
EOT;

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$gender = "";
	$identity = "";
	$userStatus = "";

	if ($row["gender"] == 0)
		$gender = "Male";
	else
		$gender = "Female";

	if ($row["identityID"] == 0)
		$identity = "Student";
	else
		$identity = "Working Professional";
	if ($coord) {
		$string = $string."<tr><td>".$row["firstName"]."</td><td>".$row["lastName"]."</td><td>".$row["email"]."</td><td>".$gender."</td><td>".$row["phone"]."</td><td>".$identity."</td><td><a href='userProfile.php?userID=".$row["ID"]."&mmSelect=1' class='btn btn-outline-info'>Mentee Profile</a></td></tr>";
	}
}

print($string);