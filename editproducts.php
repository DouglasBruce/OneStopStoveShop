<?php 
	include 'includes/overall/header.php'; 
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}
	
	if(isset($_POST['productid'])) {
		$pi=$_POST['productid'];
		$db=createConnection();
		$userdetailssql="SELECT brand, productName, category, price, short_description, long_description, picture FROM products where productID=?;";
		$userdetails = $db->prepare($userdetailssql);
		$userdetails->bind_param("i",$pi);
		$userdetails->execute();
		$userdetails->store_result();
		$userdetails->bind_result($b, $pn, $c, $p, $s, $l, $i);
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
					<h3 class="panel-title">Edit Product</h3>
				</div>
				<div class="panel-body">
					<form id="editproduct" name="editproduct" method="post" action="papplychanges.php">				
						<div class="row">
							<div class="col-md-12 padding-top-10">
								<label for="productid" class="control-label">Product ID:</label>
								<input type="text" class="form-control" id="productid" name="productid" readonly value="<?php echo $pi ?>"/>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 padding-top-10">
								<label for="brand" class="control-label">Brand:</label>
								<div class="input-group">
									<input type="text" class="form-control" id="brand" name="brand" required size="15" value="<?php echo $b ?>" />
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
								<input type="text" class="form-control" id="product_name" name="product_name" required size="15" value="<?php echo $pn ?>" />
								<div class="input-group-btn">
									<button class="btn btn-default" type="button" data-target="#productModal" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span></button>
								</div>
							</div>	
						</div>
						</div>
						<div class="row">
							<div class="col-md-4 padding-top-10">
								<label for="category" class="control-label">Category:</label>	
								<select class="form-control" id="category" name="category">
									<option value="0"><?php echo $c ?></option>
									<option value="1">Gas</option>
									<option value="2">Wood Burning</option>
									<option value="3">Multifuel</option>
								</select>	
							</div>						
							<div class="col-md-4 padding-top-10">
								<label for="price" class="control-label">Price*:</label>
								<div class="input-group">
									<span class="input-group-addon">£</span>
									<input type="text" class="form-control" id="price" name="price" required size="30" value="<?php echo $p ?>" />
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
									<input type="text" class="form-control" id="picture" name="picture" value=<?php echo $i ?> size="30" />
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
								<label for="textarea" class="control-label">Short Description:</label>
								<textarea class="form-control" id="textarea" maxlength="64" name="short"><?php echo $s ?></textarea>
								<div id="textarea_feedback"></div>
							</div>
							<div class="col-md-6 padding-top-10">
								<label for="long" class="control-label">Long Description:</label>
								<textarea class="form-control" id="long" maxlength="120" name="long"><?php echo $l ?></textarea>
								<div id="textarea_feedback2"></div>
							</div>
						</div>
						<div class="padding-top-10">
							<div class="padding-top-10 text-center">
								<a href="productlist.php" class="btn btn-primary">
									<span class="glyphicon glyphicon-menu-left"></span> Back
								</a>
								<button type="submit" class="btn btn-success">
									<span class="glyphicon glyphicon-registration-mark"></span> Save
								</button>							
							</div>	
						</div>
					</form>
				</div>
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
			</div>
		</div>
	</div>
	<!-- End of Page Content -->
<?php 
	include 'includes/overall/footer.php'; 
?>	