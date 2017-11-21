<?php 
	include 'includes/overall/header.php'; 
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}	
	
	if(isset($_POST['productid'])) {
		$pi=$_POST['productid'];
		$db=createConnection();
		$userdetailssql="SELECT brand, productName, category, short_description, long_description, price FROM products WHERE productID=?;";
		$userdetails = $db->prepare($userdetailssql);
		$userdetails->bind_param("i",$pi);
		$userdetails->execute();
		$userdetails->store_result();
		$userdetails->bind_result($b, $pn, $c, $s, $l, $p);
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
					$query = "SELECT  * FROM products WHERE productID='".$pi."'";
					
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
								echo "<p><b>Date Added:</b> ".date('g:i A j M Y', strtotime($row[7]))."</p>";
								echo "<p><b>Short Description:</b> ".$row[4]."</p>";
								echo "<p><b>Long Description:</b> ".$row[5]."</p>";
								echo "<hr>";
							}
						} 
						
					} else {
						
						echo "Couldn't issue database query<br />";
						
					}
					$_SESSION["deleteproduct"] = $pi;
					// Close connection to the database
					mysqli_close($db);			
				?>	
					<form id="deleteproduct" name="deleteproduct" method="post" action="deleteproduct.php" >
						<h4>Are you sure you wish to delete <?php echo $un; ?></h4>
						<div class="padding-top-10 text-center">
							<a href="dproductlist.php" class="btn btn-primary">
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
					<div class='row text-center'><p>No product found!</p>
					</div>
				</div>";
			}
		} else {
			echo "<div class='container'>
				<div class='row text-center'><p>No product submitted to edit!</p>
				</div>
			</div>";
		}
	?>
<?php 
	include 'includes/overall/footer.php'; 
?>	