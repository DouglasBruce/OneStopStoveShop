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
	<div class="container kv-main">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Create Product</h3>
			</div>
			<div class="panel-body">
				<form action="productconfirm.php" method="POST" id="createproduct" name="createproduct">	
					<div class="row">
						<div class="col-md-6 padding-top-10">
							<label for="brand" class="control-label">Brand*:</label>
							<div class="input-group">	
								<input type="text" class="form-control" id="brand" name="brand" placeholder="Brand" required size="15" />
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#productModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
									<!-- Modal -->
									<div class="modal fade" id="productModal" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header" >
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4>Brand & Product Name Must:</h4>
												</div>
												<div class="modal-body">
													<h4>Can contain upper & lower case</h4>
													<h4>Can contain numbers</h4>
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
							<label for="product_name" class="control-label">Product Name*:</label>
							<div class="input-group">	
								<input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" required size="15" />
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#productModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
								</div>
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 padding-top-10">
							<label for="category" class="control-label">Category*:</label>	
							<select class="form-control" id="category" name="category">
								<option value="0">Please Select</option>
								<option value="1">Gas</option>
								<option value="2">Wood Burning</option>
								<option value="3">Multifuel</option>
							</select>	
						</div>						
						<div class="col-md-4 padding-top-10">
							<label for="price" class="control-label">Price*:</label>
							<div class="input-group">
								<span class="input-group-addon">£</span>
								<input type="text" class="form-control" id="price" name="price" placeholder="Price" required size="30" />
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#priceModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
									<!-- Modal -->
									<div class="modal fade" id="priceModal" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header" >
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4>Price Must:</h4>
												</div>
												<div class="modal-body">
													<h4>Must only contain numbers</h4>
													<h4>Can contain . character</h4>
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
							<label for="picture" class="control-label">Picture*:</label>
							<div class="input-group">
								<input type="text" class="form-control" id="picture" name="picture" placeholder="Picture Name" required size="30" />
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#pictureModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
									<!-- Modal -->
									<div class="modal fade" id="pictureModal" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header" >
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4>Picture Must:</h4>
												</div>
												<div class="modal-body">
													<h4>Must contain a valid extension</h4>
													<h4>Can contain upper & lower case</h4>
													<h4>Can contain numbers</h4>
													<h4>Can contain .-_ characters</h4>
													<h4>Max 64 characters</h4>
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
							<label for="textarea" class="control-label">Short Description*:</label>
							<textarea class="form-control" id="textarea" rows="4" maxlength="64" name="short" required placeholder="Short Description Can Contain: Upper, Lower Case Letters, Numbers, Spaces, .'- Characters. Max 64 Characters."></textarea>
							<div id="textarea_feedback"></div>
						</div>
						<div class="col-md-6 padding-top-10">
							<label for="long" class="control-label">Long Description*:</label>
							<textarea class="form-control" id="long" rows="4" maxlength="120" name="long" required placeholder="Short Description Can Contain: Upper, Lower Case Letters, Numbers, Spaces, .'- Characters. Max 120 Characters."></textarea>
							<div id="textarea_feedback2"></div>
						</div>
					</div>
					<div class="padding-top-10">
						<div class="padding-top-10 text-center">
							<a href="manageproducts.php" class="btn btn-primary">
								<span class="glyphicon glyphicon-menu-left"></span> Back
							</a>
							<button type="reset" class="btn btn-warning">
								<span class="glyphicon glyphicon-erase"></span> Clear 
							</button>
							<button type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon-registration-mark"></span> Create
							</button>							
						</div>	
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End of Page Content -->
<?php 
	include 'includes/overall/footer.php'; 
?>	