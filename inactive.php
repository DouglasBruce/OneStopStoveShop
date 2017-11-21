<?php 
	include 'includes/overall/header.php';
	$username=checkUser($_SESSION['userid'],session_id(),1);
?>

	<body>

    <!-- Page Content -->
	<div class="container">	
		<div class="row">	
			<div class="text-center">
				<h3>The account <?php echo $username; ?> has been suspended until further notice!</h3>
				<button type="button" class="btn btn-danger" value="Log Out" onClick="location.href = 'php/logout.php'">
					Logout <span class="glyphicon glyphicon-menu-right"></span>
				</button>
			</div>
		</div>	
	</div>
	<!-- End of Page Content -->
	
	</body>
	
	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script>
	<script src="js/functions.js"></script>
	
</html>