<?php 
	include 'includes/overall/header.php'; 
	$un=$_SESSION["deleteuser"];
	if(isset($un)) {
		$db=createConnection();
		$query="DELETE FROM user WHERE username='".$un."'";
		@mysqli_query($db, $query);
		
		// Close connection to the database
		mysqli_close($db);
?>

<body>

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class = "col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
				<div class="well text-center">
				<legend>Success</legend>
				<p><?php echo $un." was succesfully deleted"?></p>
					<div class="row padding-top-10">					
						<form action="admin.php">
							<button type="submit" class="btn btn-success" value="Go to Admin page">
								Continue <span class="glyphicon glyphicon-menu-right"></span>
							</button>
						</form>		
					</div>	
				</div>
			</div>
		</div>
	</div>
	<!-- End of Page Content -->
	<?php
	} else {
		echo "<div class='container'>
			<div class='row text-center'><p>No user submitted to delete!</p>
			</div>
		</div>";
	}
	?>
<?php 
	include 'includes/overall/footer.php'; 
?>	