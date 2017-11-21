<?php 
	include 'includes/overall/header.php'; 
	$review=$_GET['rID'];
	if(!$review) { 
		header("location: index.php"); 
	}
?>

<body>

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="well">
				<legend>Confirm Delete</legend>
				<?php
					$db=createConnection();
					$sql = "SELECT reviewID,reviewText,reviewTime,reviewPoster,productID,username,userid FROM review JOIN user ON reviewPoster = userid WHERE reviewID=?;";
					$stmt = $db->prepare($sql);
					$stmt->bind_param("i",$review);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($reviewid,$reviewtext,$reviewtime,$reviewposter,$product_id,$username,$userid);

					//build article html
					while($stmt->fetch()) {
						echo "<div class='row'>
							<div class='col-md-12'>
								<span class='glyphicon glyphicon-star'></span>
								<span class='glyphicon glyphicon-star'></span>
								<span class='glyphicon glyphicon-star'></span>
								<span class='glyphicon glyphicon-star'></span>
								<span class='glyphicon glyphicon-star'></span>
								".$username."
								<span class='pull-right'>".date('j M Y', strtotime($reviewtime))."</span>
								<p>".$reviewtext."</p>
							</div>
						</div>";

						// if user is logged in and not suspended add delete button
						if($currentuser['userlevel']>2 || ($currentuser['userid']==$userid && $currentuser['userlevel']>1)) {
							?> <form method='post' action='php/xdeletereview.php'>
									<div class="padding-top-10 text-center">
										<a href="index.php" class="btn btn-primary">
											<span class="glyphicon glyphicon-menu-left"></span> Back
										</a>
										<?php echo "<input type='hidden' readonly value='".$review."' id='reviewid' name='reviewid' />
													<input type='hidden' readonly value='".$product_id."' id='product_id' name='product_id' />"; ?>
										<button type="submit" id="clickme" class="btn btn-danger">
											Delete <span class="glyphicon glyphicon-menu-right"></span>
										</button>								
									</div>
								</form> 
							<?php
						}
						echo "</article>";
					}
					$stmt->close();
					$db->close();
				?>
			</div>
		</div>
	</div>
	<!-- End of Page Content -->
	
<?php 
	include 'includes/overall/footer.php'; 
?>	