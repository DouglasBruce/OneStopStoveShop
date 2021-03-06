<?php 
	include 'includes/overall/header.php'; 
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}
	
	if(isset($_POST['userid'])) {
		$userid=$_POST['userid'];
		$db=createConnection();
		$userdetailssql="select usertype, username, firstname, surname, dob, housename, streetname, city, county, postcode, landline, mobile, emailadd from user where userid=?;";
		$userdetails = $db->prepare($userdetailssql);
		$userdetails->bind_param("i",$userid);
		$userdetails->execute();
		$userdetails->store_result();
		$userdetails->bind_result($usertype, $username, $firstname, $surname, $dob, $housename, $streetname, $city, $county, $postcode, $landline, $mobile, $emailadd);
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
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Edit Staff</h3>
				</div>
				<div class="panel-body">
					<form id="editstaff" name="editstaff" method="post" action="staffapplychanges.php">	
						<div class="row">
							<div class="col-md-6 padding-top-10">
								<label for="userid" class="control-label">User ID:</label>	
								<input type="text" class="form-control" id="userid" name="userid" readonly required size="15" value="<?php echo $userid; ?>" />
							</div>
							<div class="col-md-6 padding-top-10">
								<label for="usertype" class="control-label">User Type:</label>
								<div class="input-group">	
									<input type="text" class="form-control" id="usertype" name="usertype" required size="15" value="<?php echo $usertype; ?>" />
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#usertypeModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
										<!-- Modal -->
										<div class="modal fade" id="usertypeModal" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header" >
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>User Type:</h4>
													</div>
													<div class="modal-body">
														<h4>1 Banned</h4>
														<h4>2 Customer</h4>
														<h4>3 Staff</h4>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
													</div>
												</div>
												<!-- Modal Content End -->
											</div>
										</div> 
										<!-- Modal End -->
									</div>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 padding-top-10">
								<label for="username" class="control-label">Username:</label>
								<div class="input-group">
									<input type="text" class="form-control" id="username" name="username" readonly required size="15" value="<?php echo $username; ?>" />
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#usernameModal" data-toggle="modal"> <span class="glyphicon glyphicon-question-sign"></span></button>
										<!-- Modal -->
										<div class="modal fade" id="usernameModal" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header" >
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>Username Must:</h4>
													</div>
													<div class="modal-body">
														<h4>Can not be changed</h4>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
													</div>
												</div>
												<!-- Modal Content End -->
											</div>
										</div> 
										<!-- Modal End -->
									</div>
								</div>
							</div>	
						</div>
						<label for="firstname" class="control-label padding-top-10">Name:</label>
						<div class="row">
							<div class="col-md-6 padding-top-10">
								<div class="input-group">
									<input type="text" class="form-control" id="firstname" name="firstname" required size="15" value="<?php echo $firstname ?>"/>
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#nameModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
										<!-- Modal -->
										<div class="modal fade" id="nameModal" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header" >
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>Forename, Surname, & City Must:</h4>
													</div>
													<div class="modal-body">
														<h4>Not contain numbers</h4>
														<h4>Must contain upper & lower case</h4>
														<h4>Can contain -'. characters</h4>
														<h4>Can contain spaces</h4>
														<h4>Min length 2 characters</h4>
														<h4>Max length 30 characters</h4>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
													</div>
												</div>
												<!-- Modal Content End -->
											</div>
										</div> 
										<!-- Modal End -->
									</div>
								</div>	
							</div>	
							<div class="col-md-6 padding-top-10">	
								<div class="input-group">
									<input type="text" class="form-control" id="surname" name="surname" required size="15" value="<?php echo $surname ?>"/>
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#nameModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
									</div>
								</div>
							</div>
						</div>
						<label for="dob" class="control-label padding-top-10">Date of Birth:</label>
						<div class="row">
							<div class="col-md-12 padding-top-10">	
								<div class="input-group">
									<input name="dob" id="dob" type="text" class="form-control" required value="<?php echo $dob; ?>" />
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#birthdayModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
										<!-- Modal -->
										<div class="modal fade" id="birthdayModal" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header" >
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>Date of Birth Must:</h4>
													</div>
													<div class="modal-body">
														<h4>In the format YYYY-MM-DD</h4>
														<h4>Must be at least 16 years old</h4>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
													</div>
												</div>
												<!-- Modal Content End -->
											</div>
										</div> 
										<!-- Modal End -->
									</div>
								</div>
							</div>	
						</div>	
						<label for="housename" class="control-label padding-top-10">Address:</label>
						<div class="row">
							<div class="col-md-6 padding-top-10">
								<div class="input-group">
									<input type="text" class="form-control" id="housename" name="housename" required value="<?php echo $housename ?>"/>
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#housenameModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
										<!-- Modal -->
										<div class="modal fade" id="housenameModal" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header" >
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>House Name / Number Must:</h4>
													</div>
													<div class="modal-body">
														<h4>Can contain numbers</h4>
														<h4>Can contain upper & lower case</h4>
														<h4>Can contain -'. characters</h4>
														<h4>Can contain spaces</h4>
														<h4>Min length 1 characters</h4>
														<h4>Max length 40 characters</h4>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
													</div>
												</div>
												<!-- Modal Content End -->
											</div>
										</div> 
										<!-- Modal End -->
									</div>
								</div>
							</div>
							<div class="col-md-6 padding-top-10">
								<div class="input-group">
									<input type="text" class="form-control" id="streetname" name="streetname" required value="<?php echo $streetname ?>"/>
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#streetnameModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
										<!-- Modal -->
										<div class="modal fade" id="streetnameModal" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header" >
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>Street Name Must:</h4>
													</div>
													<div class="modal-body">
														<h4>Can contain numbers</h4>
														<h4>Can contain upper & lower case</h4>
														<h4>Can contain -'. characters</h4>
														<h4>Can contain spaces</h4>
														<h4>Min length 5 characters</h4>
														<h4>Max length 40 characters</h4>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
													</div>
												</div>
												<!-- Modal Content End -->
											</div>
										</div> 
										<!-- Modal End -->
									</div>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-4  padding-top-10">
								<label for="city" class="control-label">City:</label>
								<div class="input-group">
									<input type="text" class="form-control" id="city" name="city" required value="<?php echo $city ?>"/>
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#nameModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
									</div>
								</div>	
							</div>
							<div class="col-md-4  padding-top-10">
								<label for="county" class="control-label">County:</label>
								<div class="input-group">	
									<input type="text" class="form-control" id="county" name="county" required value="<?php echo $county ?>" />
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#countyModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
										<!-- Modal -->
										<div class="modal fade" id="countyModal" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header" >
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>County Must:</h4>
													</div>
													<div class="modal-body">
														<h4>Not contain numbers</h4>
														<h4>Must contain upper & lower case</h4>
														<h4>Can contain -'.& characters</h4>
														<h4>Can contain spaces</h4>
														<h4>Min length 2 characters</h4>
														<h4>Max length 30 characters</h4>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
													</div>
												</div>
												<!-- Modal Content End -->
											</div>
										</div> 
										<!-- Modal End -->
									</div>
								</div>	
							</div>
							<div class="col-md-4  padding-top-10">
								<label for="postcode" class="control-label">Postcode:</label>
								<div class="input-group">
									<input type="text" class="form-control" id="postcode" name="postcode" required value="<?php echo $postcode ?>" />
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#postcodeModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
										<!-- Modal -->
										<div class="modal fade" id="postcodeModal" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header" >
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>Postcode Must:</h4>
													</div>
													<div class="modal-body">
														<h4>Can contain numbers</h4>
														<h4>Can contain upper & lower case</h4>
														<h4>Can contain spaces</h4>
														<h4>Min length 4 characters</h4>
														<h4>Max length 9 characters</h4>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
													</div>
												</div>
												<!-- Modal Content End -->
											</div>
										</div> 
										<!-- Modal End -->
									</div>
								</div>	
							</div>
						</div>
						<div class="row">
						<div class="col-md-4 padding-top-10">
							<label for="landline" class="control-label">Telephone Number:</label>
							<div class="input-group">	
								<input type="text" class="form-control" id="landline" name="landline" value="<?php echo $landline ?>" />
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#telephoneModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
									<!-- Modal -->
									<div class="modal fade" id="telephoneModal" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header" >
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4>Telephone Number Must:</h4>
												</div>
												<div class="modal-body">
													<h4>Must contain numbers</h4>
													<h4>Can contain spaces</h4>
													<h4>Min length 5 characters</h4>
													<h4>Max length 14 characters</h4>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
												</div>
											</div>
											<!-- Modal Content End -->
										</div>
									</div> 
									<!-- Modal End -->
								</div>
							</div>	
						</div>
						<div class="col-md-4 padding-top-10">
							<label for="mobile" class="control-label">Mobile Number:</label>
							<div class="input-group">	
								<input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile ?>" />
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#phoneModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
									<!-- Modal -->
									<div class="modal fade" id="phoneModal" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header" >
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4>Mobile Number Must:</h4>
												</div>
												<div class="modal-body">
													<h4>Must contain numbers</h4>
													<h4>Can contain spaces</h4>
													<h4>Can contain +</h4>
													<h4>Min length 5 characters</h4>
													<h4>Max length 14 characters</h4>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
												</div>
											</div>
											<!-- Modal Content End -->
										</div>
									</div> 
									<!-- Modal End -->
								</div>
							</div>	
						</div>						
						<div class="col-md-4 padding-top-10">
							<label for="emailadd" class="control-label">Email Address:</label>
							<div class="input-group">
								<input type="email" class="form-control" id="emailadd" name="emailadd" required size="30" value="<?php echo $emailadd ?>" />
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#emailModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
									<!-- Modal -->
									<div class="modal fade" id="emailModal" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header" >
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4>Email Must:</h4>
												</div>
												<div class="modal-body">
													<h4>Can contain upper & lower case</h4>
													<h4>Can contain numbers</h4>
													<h4>Can contain ._-</h4>
													<h4>Can't contain . after @</h4>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
												</div>
											</div>
											<!-- Modal Content End -->
										</div>
									</div> 
									<!-- Modal End -->
								</div>
							</div>	
						</div>							
					</div>
						<div class="row">	
							<div class="col-md-12 padding-top-10">
								<label for="userpass" class="control-label">Password:</label>
								<div class="input-group">	
									<input type="password" class="form-control" id="userpass" name="userpass" placeholder="Password" size="15" />
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" data-target="#passModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
										<!-- Modal -->
										<div class="modal fade" id="passModal" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header" >
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4>Password Must:</h4>
													</div>
													<div class="modal-body">
														<h4>Can not match your username</h4>
														<h4>Must contain 1 upper case letter</h4>
														<h4>Must contain 1 lower case letter</h4>
														<h4>Must contain 1 number</h4>
														<h4>Can contain -_ characters</h4>
														<h4>Min length 8 characters</h4>
														<h4>Max length 25 characters</h4>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-default btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>				
													</div>
												</div>
												<!-- Modal Content End -->
											</div>
										</div> 
										<!-- Modal End -->
									</div>
								</div>	
							</div>
						</div>	
						<div class="padding-top-10 text-center">
							<a href="stafflist.php" class="btn btn-primary">
								<span class="glyphicon glyphicon-menu-left"></span> Back
							</a>
							<button class="btn btn-success" type="submit">
								Save <span class="glyphicon glyphicon-menu-right"></span>
							</button>						
						</div>	
					</form>
				</div>
			</div>	
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
	
		</div>
	</div>
	
	<!-- End of Page Content -->
	
	<script src="js/register.js"></script>
	<script>
		document.onreadystatechange = function(){
			if(document.readyState=="complete") {
				prepareRegister();
			}
		}
	</script>
	
<?php 
	include 'includes/overall/footer.php'; 
?>	