<?php 
	include 'includes/overall/header.php'; 
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}
?>

<body>

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">	
		<div class="row">	
			<div class = "col-md-6 col-md-offset-3">
				<div class="well text-center">
				<legend> Staff </legend>
					<div class="row padding-top-10">					
						<form action="managestaff.php">
							<button type="submit" class="btn btn-primary" value="Go to Manage Users">
								<span class="glyphicon glyphicon-menu-left"></span>	Back 
							</button>
						</form>		
					</div>
					<div>
						<hr>
					</div>	
					<?php
						
						$db = createConnection();
						
						// Create a query for the database
						$query = "SELECT  * FROM user WHERE usertype=3";
						 
						// Get a response from the database by sending the connection
						// and the query
						$response = @mysqli_query($db, $query);
						 
						// If the query executed properly proceed
						if($response){
						 
							if (mysqli_num_rows($response) > 0) {
								while($row = mysqli_fetch_row($response)) {
									echo "<p><b>Username:</b> ".$row[2]."</p>";
									echo "<p><b>Full Name:</b> ".$row[7]." ".$row[8]."</p>";
									echo "<p><b>Date of Birth:</b> ".$row[14]."</p>";
									echo "<p><b>Address:</b> ".$row[9].", ".$row[10].", ".$row[11].", ".$row[12].", ".$row[13]."</p>";
									echo "<p><b>Email Address:</b> ".$row[15]."</p>";
									echo "<p><b>Telephone Number:</b> ".$row[16]."</p>";
									echo "<p><b>Mobile Number:</b> ".$row[17]."</p>";
									echo "<hr>";
								}
							} 
						 
						} else {
						 
							echo "Couldn't issue database query<br />";
						 
						}
						 
						// Close connection to the database
						mysqli_close($db);			
					?>
					<div class="row padding-top-10">					
						<form action="managestaff.php">
							<button type="submit" class="btn btn-primary" value="Go to Manage Users">
								<span class="glyphicon glyphicon-menu-left"></span>	Back 
							</button>
						</form>		
					</div>
				</div>	
			</div>	
		</div>	
	</div>	
	<!-- End of Page Content -->
	
<?php 
	include 'includes/overall/footer.php'; 
?>	