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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Registration</h3>
			</div>
			<div class="panel-body">
				<form action="staffconfirm.php" method="POST" id="registeruser" name="registeruser">				
					<label for="username" class="control-label">Username*:</label>
					<div class="row">
						<div class="col-md-12 padding-top-10">
							<div class="input-group">
								<input type="text" class="form-control" id="username" name="username" placeholder="Username" required size="15" /><span id="usernameFb"></span>
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
													<h4>Must contain 1 upper case letter</h4>
													<h4>Must contain 1 lower case letter</h4>
													<h4>Can contain -_ characters</h4>
													<h4>Min length 5 characters</h4>
													<h4>Max length 25 characters</h4>
													<h4>Can not be changed at a later date</h4>
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
					<label for="firstname" class="control-label padding-top-10">Name*:</label>
					<div class="row">
						<div class="col-md-6 padding-top-10">
							<div class="input-group">
								<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Forename" required size="15" /><span id="firstnameFb"></span>
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
								<input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" required size="15" /><span id="surnameFb"></span>
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#nameModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
								</div>
							</div>
						</div>
					</div>
					<label for="dayob" class="control-label padding-top-10">Date of Birth*:</label>
					<div class="row">
						<div class="col-md-3">
							<label class="datelabel" for="dayob">Day</label><select class="form-control" name="dayob" id="dayob"></select>
						</div>
						<div class="col-md-6">
							<label class="datelabel" for="monthob">Month</label>
							<select class="form-control" name="monthob" id="monthob">
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</div>
						<div class="col-md-3">
							<label class="datelabel" for="yearob">Year</label><select class="form-control" name="yearob" id="yearob"></select><span id="ageFb"></span>
						</div>
					</div>											
					<label for="housename" class="control-label padding-top-10">Address*:</label>
					<div class="row">
						<div class="col-md-6 padding-top-10">
							<div class="input-group">
								<input type="text" class="form-control" id="housename" name="housename" placeholder="House Name / Number" required /><span id="housenameFb"></span>
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
								<input type="text" class="form-control" id="streetname" name="streetname" placeholder="Street Name" required /><span id="streetnameFb"></span>
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
							<label for="city" class="control-label">City*:</label>
							<div class="input-group">
								<input type="text" class="form-control" id="city" name="city" placeholder="City" required /><span id="cityFb"></span>
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#nameModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
								</div>
							</div>	
						</div>
						<div class="col-md-4  padding-top-10">
							<label for="county" class="control-label">County*:</label>
							<div class="input-group">	
								<input type="text" class="form-control" id="county" name="county" placeholder="County" required /><span id="countyFb"></span>
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
							<label for="postcode" class="control-label">Postcode*:</label>
							<div class="input-group">
								<input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" required /><span id="postcodeFb"></span>
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
								<input type="text" class="form-control" id="landline" name="landline" placeholder="Telephone Number" />
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
								<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" />
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
							<label for="emailadd" class="control-label">Email Address*:</label>
							<div class="input-group">
								<input type="email" class="form-control" id="emailadd" name="emailadd" placeholder="you@example.com" required size="30" /><span id="emailFb"></span>
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
													<h4>Can only cotain one . after @</h4>
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
						<div class="col-md-6 padding-top-10">
							<label for="userpass" class="control-label">Password*:</label>
							<div class="input-group">	
								<input type="password" class="form-control" id="userpass" name="userpass" placeholder="Password" required size="15" /><span id="userpassFb"></span>
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
						<div class="col-md-6 padding-top-10">
							<label for="secondpass" class="control-label">Confirm Password*:</label>
							<div class="input-group">	
								<input type="password" class="form-control" id="secondpass" name="secondpass" placeholder="Confirm Password" required size="15" /><span id="secondpassFb"></span>
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#conpassModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
									<!-- Modal -->
									<div class="modal fade" id="conpassModal" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header" >
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4>Confirm Password Must:</h4>
												</div>
												<div class="modal-body">
													<h4>Must match password</h4>
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
						<div class="row">
							<div class="col-md-5 padding-top-10">
								<label for="passstrresult" style="margin-left:15px;">Strength:</label>
								<div id="passstrresult" name="passstrresult" style="height:20px;display:inline-block;margin-left:15px;"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 padding-top-10">
							<div class="checkbox">
								<label>
									<input type="checkbox" id="tnc" name="tnc" required /><span id="tncFb"></span> I agree to the <a href="#">Terms & Conditions</a>
								</label>
							</div>
						</div>
					</div>
					<div class="padding-top-10 text-center">
						<a href="managestaff.php" class="btn btn-primary">
							<span class="glyphicon glyphicon-menu-left"></span> Back
						</a>
						<button type="reset" class="btn btn-warning">
							<span class="glyphicon glyphicon-erase"></span> Clear 
						</button>
						<button type="submit" class="btn btn-success">
							<span class="glyphicon glyphicon-registration-mark"></span> Register
						</button>							
					</div>										
				</form>
			</div>
		</div>
		<script src="js/register.js"></script>
		<script>
			document.onreadystatechange = function(){
				if(document.readyState=="complete") {
					prepareRegister();
				}
			}
		</script>
	</div>
	<!-- End of Page Content -->
	
<?php 
	include 'includes/overall/footer.php'; 
?>	