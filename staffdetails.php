<?php 
	include 'includes/overall/header.php';
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}	
?>

<body id="about">

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class = "col-md-6 col-md-offset-3 padding-top-10 text-center">
				<div class="well text-center">
					<legend>Account Details</legend>
					<?php
						
						$db = createConnection();
						
						// Create a query for the database
						$query = "SELECT  * FROM user WHERE username='".$currentuser['username']."'";
						 
						// Get a response from the database by sending the connection
						// and the query
						$response = @mysqli_query($db, $query);
						 
						// If the query executed properly proceed
						if($response){
						 
							if (mysqli_num_rows($response) > 0) {
								while($row = mysqli_fetch_array($response)) {
									$un = $row['username'];
									$fn = $row['firstname'];
									$ln = $row['surname'];
									$dob = $row['dob'];
									$h = $row['housename'];
									$s = $row['streetname'];
									$c = $row['city'];
									$co = $row['county'];
									$pt = $row['postcode'];
									$e = $row['emailadd'];
									$l = $row['landline'];
									$m = $row['mobile'];
								}
							} 
							echo "<b>Username:</b> ".$un."<br />";
							echo "<b>Full Name:</b> ".$fn." ".$ln."<br />";
							echo "<b>Date of Birth:</b> ".$dob."<br />";
							echo "<b>Address:</b> ".$h.", ".$s.", ".$c.", ".$co.", ".$pt."<br />";
							echo "<b>Email Address: </b>".$e."<br />";
							echo "<b>Telephone Number:</b> ".$l."<br />";
							echo "<b>Mobile Number:</b> ".$m."<br />";
							echo "<hr>";
						} else {
						 
							echo "Couldn't issue database query<br />";
						 
						}
						 
						// Close connection to the database
						mysqli_close($db);	
					?>
					<div class="padding-top-10 text-center">
						<a href="admin.php" class="btn btn-primary">
							<span class="glyphicon glyphicon-menu-left"></span> Back
						</a>
						<a href="editstaffs.php" type="submit" class="btn btn-success">
							<span class="glyphicon glyphicon-edit"></span> Edit <span class="glyphicon glyphicon-menu-right"></span>
						</a>						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Page Content -->
	
<?php 
	include 'includes/overall/footer.php'; 
?>	