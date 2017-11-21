<?php 
	include 'includes/overall/header.php';	
	if($currentuser['userlevel']!=2) {
		header("location: index.php");
	}
?>
<body id="account">
    <?php 
		include 'includes/menu.php'; 
	?>
    <!-- Page Content -->
	<div class="container">			
		<div class = "row">
			<div>
				<p>Welcome Back <?php echo $currentuser['username']; ?></p>
			</div>
		</div>
		<div class = "row">				
			<div class="text-center">
				<h2>Account</h2>
				<h3>Welcome to your account page!</h3>
			</div>
		</div>	
		<div class="row">
			<div class = "col-md-6">
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
					<div class="text-center">
						<form action="edituser.php">
							<a href="delete.php" class="btn btn-danger">
								<span class="glyphicon glyphicon-menu-left"></span> Delete
							</a>
							<button class="btn btn-success" type="submit">
								<span class="glyphicon glyphicon-edit"></span> Edit <span class="glyphicon glyphicon-menu-right"></span>
							</button>								
						</form>							
					</div>
				</div>
			</div>
			<div class = "col-md-6">
				<div class="well text-center">
					<legend>Purchase History</legend>
					<div class="row">	
						<div class='col-sm-4 text-left'>
							<span>
								<h5><b>Product</b></h5>
							</span>
							<div class='row'>
								<div class='col-sm-12 padding-top-10 sc-border text-left'>
									<a href="index.php?view_product=3">MaxFloV3.0</a><br>
									<a href="index.php?view_product=5">WarmFloV2.0</a>
								</div>
							</div>
						</div>
						<div class='col-sm-2 text-left'>
							<span>
								<h5><b>Price</b></h5>
							</span>
							<div class='row'>
								<div class='col-sm-12 padding-top-10 text-left sc-border'>
									<span class='sc-color'>
										<b>£389.99</b><br>
										<b>£249.99</b>
									</span>
								</div>
							</div>
						</div>
						<div class='col-sm-3 text-right'>
							<span>
								<h5><b>Quantity</b></h5>
							</span>
							<div class='row'>
								<div class='col-sm-12 padding-top-10 sc-border'>
									2<br>
									5
								</div>
							</div>
						</div>
						<div class='col-sm-3 text-left'>
							<span>
								<h5><b>Total</b></h5>
							</span>
							<div class='row'>
								<div class='col-sm-12 padding-top-10 text-left sc-border'>
									<span class='sc-color'>
										<b>£779.98</b><br>
										<b>£1,249.95</b>
									</span>
								</div>
							</div>
						</div>
					</div>	
					<div class="text-center">
						<hr>	
						<form action="#">
							<button type="submit" class="btn btn-success">
								View <span class="glyphicon glyphicon-menu-right"></span>
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