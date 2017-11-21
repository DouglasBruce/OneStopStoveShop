<?php 
	include 'includes/overall/header.php'; 
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}
	
	$db=createConnection();
	$userlistsql="SELECT userid, username FROM user WHERE usertype<3;";
	$userlist = $db->prepare($userlistsql);
	$userlist->execute();
	$userlist->store_result();
	$userlist->bind_result($userid,$username);
	if($userlist->num_rows>0) {
	
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
					<form id="listusers" name="listusers" method="post" action="editusers.php" >
						<fieldset>
							<legend>Edit User</legend>
							<label for="userid" class="control-label">Select User to Edit: </label>
							<select class="form-control" name="userid" id="userid" required>
							<?php
								while($userlist->fetch()) {
									echo "<option value='$userid'>$username</option>";
								}
							?>
							</select>
							<div class="padding-top-10 text-center">
								<a href="manageusers.php" class="btn btn-primary">
									<span class="glyphicon glyphicon-menu-left"></span> Back
								</a>
								<button class="btn btn-success" type="submit">
									<span class="glyphicon glyphicon-edit"></span> Edit User <span class="glyphicon glyphicon-menu-right"></span>
								</button>								
							</div>
						</fieldset>
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
	?>
	
<?php 
	include 'includes/overall/footer.php'; 
?>	