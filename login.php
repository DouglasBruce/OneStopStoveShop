<?php 
	include 'includes/overall/header.php'; 
?>

<body id="login">

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class = "col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
				<div class="well text-center">
					<?php if($currentuser['userlevel']<1) { ?><form name="loginform" id="loginform" method="post" action="php/processlogin.php">
						<legend>Login</legend>
						<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-user"></span>
							</span>
							<input type="text" class="form-control" name="username" id="username" placeholder="Username" size="10" required />
						</div>
						<div class="input-group padding-top-10">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-lock"></span>
							</span>
							<input type="password" class="form-control" name="userpass1" id="userpass1" placeholder="Password" size="10" required />
						</div>												
						<div class="checkbox text-center">
							<label><input type="checkbox" value="">Remember me</label>
						</div>	
						<div class="text-center">
							<button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>									
						</div>
						<?php } else { ?>
							<div class="text-center">
								<h3>Welcome Back <?php echo $currentuser['username']; ?></h3>
								<button type="button" class="btn btn-danger" value="Log Out" onClick="location.href = 'php/logout.php'">
									Logout <span class="glyphicon glyphicon-menu-right"></span>
								</button>
							</div>
						<?php } ?>
						</form>
					<?php if($currentuser['userlevel']<2) { ?>
					<div class="text-center padding-top-10">
						<p>Not a member? <a href="registration.php"><span class="glyphicon glyphicon-registration-mark"></span> Sign Up</a></p>
						<p><a href="#"><span class="glyphicon glyphicon-question-sign"></span> Forgotten your password?</a></p>	
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Page Content -->
	
<?php 
	include 'includes/overall/footer.php'; 
?>		