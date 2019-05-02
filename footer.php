
<footer>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a href="#" class="navbar-brand">Baci Project</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') { echo 'active';} ?>">
						<a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
					</li>
					<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
					<!--##### ADD LOGGED IN HEADER LINKS BELOW ##### -->
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'dashboard.php') { echo 'active';} ?>">
						<a class="nav-link" href="dashboard.php">Dashboard</a>
					</li>
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'logout.php') { echo 'active';} ?>">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>
					<?php } else { ?>
					<!--##### ADD NOT LOGGED IN HEADER LINKS BELOW ##### -->
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'registration.php') { echo 'active';} ?>">
						<a class="nav-link" href="registration.php">Register</a>
					</li>
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'login.php') { echo 'active';} ?>">
						<a class="nav-link" href="login.php">Login</a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>
</footer>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/datatables.min.js"></script>
<script src="js/main.js"></script> 
</body>

</html>