<?php 
	include 'includes/overall/header.php'; 
?>

<body>

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container kv-main">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Image Uploader</h3>
				</div>
				<div class="panel-body">
					<form action="upload.php" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-12 padding-top-10">	
								<div class="form-group">
									<input id="images" name="images" type="file" class="file-loading" accept="image/*" multiple>
								</div>
							</div>	
						</div>
						<div class="padding-top-10">
						<div class="padding-top-10 text-center">
							<a href="manageproducts.php" class="btn btn-primary">
								<span class="glyphicon glyphicon-menu-left"></span> Back
							</a>						
						</div>	
					</div>
					</form>
				</div>	
			</div>	
		</div>
	</div>
	<!-- End of Page Content -->
<?php 
	include 'includes/overall/footer.php'; 
?>	