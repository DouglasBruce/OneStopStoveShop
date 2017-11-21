<?php 
	include 'includes/overall/header.php'; 
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}	
	
	if(isset($_POST['userid'])) {
		$ui=$_POST['userid'];
		$db=createConnection();
		$userdetailssql="select usertype, username, firstname, surname, dob, housename, streetname, city, county, postcode, landline, mobile, emailadd from user where userid=?;";
		$userdetails = $db->prepare($userdetailssql);
		$userdetails->bind_param("i",$ui);
		$userdetails->execute();
		$userdetails->store_result();
		$userdetails->bind_result($ut, $un, $fn, $ln, $dob, $h, $s, $c, $co, $pt, $l, $m, $e);
		if($userdetails->num_rows==1) {
			$userdetails->fetch();
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
				<legend>Delete</legend>
				<?php
					
					$db = createConnection();
					
					// Create a query for the database
					$query = "SELECT  * FROM user WHERE userid='".$ui."'";
					
					// Get a response from the database by sending the connection
					// and the query
					$response = @mysqli_query($db, $query);
					
					// If the query executed properly proceed
					if($response){
						
						if (mysqli_num_rows($response) > 0) {
							while($row = mysqli_fetch_row($response)) {
								echo "<p><b>Username:</b> ".$row[2]."</p>";
								echo "<p><b>User Type:</b> ".$row[1]."</p>";
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
					$_SESSION["deleteuser"] = $un;
					// Close connection to the database
					mysqli_close($db);			
				?>	
					<form id="deleteuser" name="deleteuser" method="post" action="deleteuser.php" >
						<h4>Are you sure you wish to delete <?php echo $un; ?></h4>
						<div class="padding-top-10 text-center">
							<a href="duserlist.php" class="btn btn-primary">
								<span class="glyphicon glyphicon-menu-left"></span> Back
							</a>
							<button class="btn btn-danger" type="submit" name="submit">
								Delete <span class="glyphicon glyphicon-menu-right"></span>
							</button>								
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<!-- End of Page Content -->
	<?php
			} else {
				echo "<div class='container'>
					<div class='row text-center'><p>No user found!</p>
					</div>
				</div>";
			}
		} else {
			echo "<div class='container'>
				<div class='row text-center'><p>No user submitted to edit!</p>
				</div>
			</div>";
		}
	?>
<?php 
	include 'includes/overall/footer.php'; 
?>	