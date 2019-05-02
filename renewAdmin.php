<?php 
require_once 'header.php';
require_once "db_connect.php"	;

$user = $_SESSION['user'];
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}
$userPriv = $user->getUserPrivilege();
if($userPriv != 3){
	header('Location: dashboard.php');
}	

$userID = ($_GET["userID"]);

$stmt = $con->prepare("UPDATE user_tbl SET active = 1 WHERE ID = :userID");
$stmt -> execute(array('userID' => $userID));
?>

<div class="container" id="renewUser">
	<section id="renewUser">
		<h2>Activated user with ID: <?php echo $userID ?></h2>
	</section>
	
</div>

<?php include 'footer.php'; ?>