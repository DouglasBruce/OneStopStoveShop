<?php 
	include 'includes/overall/header.php'; 
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}
	
	$db=createConnection();
	$userlistsql="SELECT productID, productName FROM products;";
	$userlist = $db->prepare($userlistsql);
	$userlist->execute();
	$userlist->store_result();
	$userlist->bind_result($productID,$productName);
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
					<form id="listproducts" name="listproducts" method="post" action="pconfirmdelete.php" >
						<fieldset>
							<legend>Delete Product</legend>
							<label for="productid" class="control-label">Select Product to Delete: </label>
							<select class="form-control" name="productid" id="productid" required>
							<?php
								while($userlist->fetch()) {
									echo "<option value='$productID'>$productName</option>";
								}
							?>
							</select>
							<div class="padding-top-10 text-center">
								<a href="manageproducts.php" class="btn btn-primary">
									<span class="glyphicon glyphicon-menu-left"></span> Back
								</a>
								<button class="btn btn-success" type="submit">
									<span class="glyphicon glyphicon-edit"></span> Delete Product <span class="glyphicon glyphicon-menu-right"></span>
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