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
				<legend> Products </legend>
					<div class="row">					
						<form action="manageproducts.php">
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
						$query = "SELECT  * FROM products";
						 
						// Get a response from the database by sending the connection
						// and the query
						$response = @mysqli_query($db, $query);
						 
						// If the query executed properly proceed
						if($response){
						 
							if (mysqli_num_rows($response) > 0) {
								while($row = mysqli_fetch_row($response)) {
									echo "<p><b>Brand:</b> ".$row[1]."</p>";
									echo "<p><b>Product Name:</b> ".$row[2]."</p>";
									echo "<p><b>Product Type:</b> ".$row[3]."</p>";
									echo "<p><b>Price:</b> £".$row[6]."</p>";
									echo "<p><b>Rating:</b> ".$row[8]." Stars</p>";
									echo "<p><b>Number of Reviews:</b> ".$row[9]."</p>";
									echo "<p><b>Date Added:</b> ".date('j M Y', strtotime($row[7]))."</p>";
									echo "<p><b>Short Description:</b> ".$row[4]."</p>";
									echo "<p><b>Long Description:</b> ".$row[5]."</p>";
									echo "<p><b>Picture:</b> ".$row[10]."</p>";
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
						<form action="manageproducts.php">
							<button type="submit" class="btn btn-primary" value="Go to Manage Products">
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