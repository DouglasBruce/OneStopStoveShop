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
		<div class = "row">	
			<div class = "well col-md-4 col-md-offset-4 padding-top-10 text-center">	
				<legend> Manage Users </legend>
				<div class="row padding-top-10">	
					<form action="reguser.php">
						<button type="submit" class="btn btn-success" value="Go to Registration">
							Create User <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">	
					<form action="getuser.php">
						<button type="submit" class="btn btn-success" value="Go to Registration">
							View Users <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">
					<form action="userlist.php">
						<button type="submit" class="btn btn-success" value="Go to Userlist">
							Edit User <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">
					<form action="duserlist.php">
						<button type="submit" class="btn btn-success" value="Go to Userlist">
							Delete User <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">					
					<form action="admin.php">
						<button type="submit" class="btn btn-primary" value="Go to Manage Users">
							<span class="glyphicon glyphicon-menu-left"></span>	Back 
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