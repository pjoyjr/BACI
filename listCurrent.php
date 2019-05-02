<?php 
include 'header.php'; 
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}
$user = $_SESSION['user'];
$priv = $user->getUserPrivilege();

if ($priv != 1 && $priv != 2 && $priv != 3) {
 	header('Location: dashboard.php');
}
?>

<section id="listUsers">
	<div class="container mt-2">
		<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
	</div>
	<div class="container mt-3">
		<div id="tableCurrent" class="table-responsive"></div>
	</div>
</section>

<?php include 'footer.php'; ?>