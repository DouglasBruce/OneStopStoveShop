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
				<legend> Manage Staff </legend>
				<div class="row padding-top-10">	
					<form action="regstaff.php">
						<button type="submit" class="btn btn-success" value="Go to Registration">
							Create Staff <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">	
					<form action="getstaff.php">
						<button type="submit" class="btn btn-success" value="Go to Registration">
							View Staff <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">
					<form action="stafflist.php">
						<button type="submit" class="btn btn-success" value="Go to Stafflist">
							Edit Staff <span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</form>
				</div>
				<div class="row padding-top-10">
					<form action="dstafflist.php">
						<button type="submit" class="btn btn-success" value="Go to Stafflist">
							Delete Staff <span class="glyphicon glyphicon-menu-right"></span>
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