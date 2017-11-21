<?php 
	include 'includes/overall/header.php'; 
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}	
?>
<body id="admin">
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
			<div class = "well col-md-4 col-md-offset-4 padding-top-10 text-center">	
				<legend>Administration</legend>
				<div class="row padding-top-10">
					<form action="staffdetails.php">
						<button type="submit" class="btn btn-success" value="Go to Manage Services">
							Account Details <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">	
					<form action="manageproducts.php">
						<button type="submit" class="btn btn-success" value="Go to Manage Products">
							Manage Products <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">
					<form action="https://my.setmore.com/" target="_blank">
						<button type="submit" class="btn btn-success" value="Go to Manage Bookings">
							Manage Bookings <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">
					<form action="manageusers.php">
						<button type="submit" class="btn btn-success" value="Go to Manage Users">
							Manage Users <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">
					<form action="managestaff.php">
						<button type="submit" class="btn btn-success" value="Go to Manage Staff">
							Manage Staff <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
			</div>				
		</div>
	</div>		
	<!-- End of Page Content -->
<?php 
	include 'includes/overall/footer.php'; 
?>	