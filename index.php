<?php 
	include 'includes/overall/header.php'; 
	$db = createConnection();
						
	if (isset($_GET['category'])) {
		$c = $_GET['category'];
		$message = $c;
		if ($c=='All'){
			// Create a query for the database
			$query = "SELECT  * FROM products ORDER BY rating DESC;";
		} else if ($c=='Wood Burning'){
			// Create a query for the database
			$query = "SELECT  * FROM products WHERE category='Wood Burning' ORDER BY rating DESC;";
		} else if ($c=='Gas'){
			// Create a query for the database
			$query = "SELECT  * FROM products WHERE category='Gas' ORDER BY rating DESC;";
		} else if($c=='Multifuel'){
			// Create a query for the database
			$query = "SELECT  * FROM products WHERE category='Multifuel' ORDER BY rating DESC;";
		} else {
			// Create a query for the database
			$query = "SELECT  * FROM products ORDER BY rating DESC;";
		}
	} else {
		// Create a query for the database
		$query = "SELECT  * FROM products ORDER BY rating DESC;";
	}
	 
	// Get a response from the database by sending the connection and the query
	$response = @mysqli_query($db, $query);
						 
	// If the query executed properly proceed
	if($response){
		if (mysqli_num_rows($response) > 0) {
			while($row = mysqli_fetch_array($response)) {
				$data_item['id'] = $row['productID']; 
				$data_item['brand'] = $row['brand']; 
				$data_item['name'] = $row['productName'];
				$data_item['category'] = $row['category'];
				$data_item['short'] = $row['short_description'];
				$data_item['long'] = $row['long_description'];
				$data_item['price'] = $row['price'];
				$data_item['date_added'] = $row['date_added'];
				$data_item['rating'] = $row['rating'];
				$data_item['reviews'] = $row['numOfReviews'];
				$data_item['picture'] = $row['picture'];
	
				$products[$row['productID']] = $data_item;
			}
		} 
	} else {
		echo "<div class='container'>
					<div class='row text-center'><p>The store is currently undergoing maintenance. Sorry for the inconvenience<br /></p>
					</div>
				</div>";
	}
	// Close connection to the database
	mysqli_close($db);
					
	// Initialize cart
	if(!isset($_SESSION['shopping_cart'])) {
		$_SESSION['shopping_cart'] = array();
	}
	// Empty cart
	if(isset($_GET['empty_cart'])) {
		$_SESSION['shopping_cart'] = array();
		header("location: index.php?view_cart");
		if(!$message) {
			$message = "Cart emptied!<br />";
		}
	}

	// **PROCESS FORM DATA**
	
	$message = '';

	// Add product to cart
	if(isset($_POST['add_to_cart'])) {
		$product_id = $_POST['product_id'];
					
		// Check for valid item
		if(!isset($products[$product_id]['id'])) {
			$message = "Invalid item!<br />";
		} else if(isset($_SESSION['shopping_cart'][$product_id])) { // If item is already in cart, tell user
			$message = "Item already in cart!<br />";
		} else { // Otherwise, add to cart
			$_SESSION['shopping_cart'][$product_id]['product_id'] = $_POST['product_id'];
			$_SESSION['shopping_cart'][$product_id]['quantity'] = $_POST['quantity'];
			header("location: index.php?view_cart");
			$message = "Added to cart!";
		}
	}
	
	// Remove a single item from the cart
	if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
		// Access the array and run code to remove that array index
		$key_to_remove = $_POST['index_to_remove'];
		if (count($_SESSION["shopping_cart"]) <= 1) {
			unset($_SESSION["shopping_cart"]);
		} else {
			echo $key_to_remove;
			unset($_SESSION["shopping_cart"]["$key_to_remove"]);
		}
	}
	
	// Update Cart
	if(isset($_POST['update_cart'])) {
		$quantities = $_POST['quantity'];
		foreach($quantities as $id => $quantity) {
			if(!isset($products[$id])) {
				$message = "Invalid product!";
				break;
			}
			$_SESSION['shopping_cart'][$id]['quantity'] = $quantity;
		}
		if(!$message) {
			$message = "Cart updated!<br />";
		}
	}
	
	// Add review
	if(isset($_POST['add_review'])) {
		$product_id = $_POST['product_id'];
		$username=checkUser($_SESSION['userid'],session_id(),2);
		$currentuser=getUserLevel();
		$db=createConnection();
		
		$ra = $_POST['rating'];
		
		if (preg_match ('%^[A-Za-z0-9\,\+\.\' \-]{1,80}$%', stripslashes(trim($_POST['comment'])))) { 
			$re = $_POST['comment']; 
		} else { 
			$re = FALSE; 		 
		}
			
		if($re && $ra) {

			// insert new review
			$insertquery="INSERT INTO review (reviewText,reviewRating,reviewPoster,productID,reviewTime) VALUES (?,?,?,?,now())";
			$insertreview=$db->prepare($insertquery);
			$insertreview->bind_param("siii",$re,$ra,$currentuser['userid'],$product_id);
			$insertreview->execute();
			
			if($insertreview->affected_rows==1) {
				
				$sql = "SELECT numOfReviews FROM products WHERE productID='$product_id';";

				$stmt = $db->prepare($sql);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($numReviews);
				$stmt->fetch();
				
				$newNumReviews = $numReviews + 1;
				
				
				$sql = "SELECT reviewRating FROM review WHERE productID='$product_id';";

				$stmt = $db->prepare($sql);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($rating);
				
				while($stmt->fetch()) {
					$totalRating += $rating;
				}
				
				$newRating = $totalRating / $newNumReviews;
				
				$updatequery="UPDATE products SET numOfReviews='$newNumReviews', rating='$newRating' WHERE productID='$product_id';";
				$update=$db->prepare($updatequery);
				$update->bind_param("ii",$newNumReviews, $newRating);
				$update->execute();
				
				header("location: index.php?view_product=$product_id");
				
			} else { 
				//feedback there was a problem adding the user
				echo "<div class='container'>
						<div class='row text-center'><p>There was a problem adding your review. Please contact the website administrators.</p>
							</div>
						</div>";
			}
		} else { 
			// review failed either due to disabled javascript or other attempt to bypass validation
			?>	
				<div class="container">
					<div class="row">		
						<header>
							<h1>Review Failed</h1>
						</header>
						<?php 
							if($re==FALSE){echo '<p>Please enter a valid review.</p>';}		
							echo "<p>You need to return to the <a href = 'index.php?view_product=$product_id'>product</a> page and try again</p>";
						?>	
					</div>
				</div>
			<?php 
		}
		$stmt->close();
		$insertreview->close();
		$update->close();
		$db->close();
	}
?>

<body id = "store">

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">
		<div class="row">
			<?php
			
				// **DISPLAY PAGE**

				echo $message;

				// View a product
				if(isset($_GET['view_product'])) {
					$pi = $_GET['view_product'];
										
					if(isset($products[$pi]['id'])) {
						?>
						<!-- Display product -->
						<div class="container">
							<div class="row">
								<?php
									echo "<div class='col-md-3 hidem1'>
											<div data-spy='affix'>
												<p class='lead'>One Stop Stove Shop</p>
												<div class='list-group'>
													<a href='index.php?category=All' class='list-group-item'>
														All Products
													</a>
													<a href='index.php?category=Wood Burning' class='list-group-item'>
														Wood Burning Stoves
													</a>
													<a href='index.php?category=Gas' class='list-group-item'>
														Gas Stoves
													</a>
													<a href='index.php?category=Multifuel' class='list-group-item'>
														Multifuel Stoves
													</a>
												</div>
											</div>
										</div>";
										echo "<div class='col-sm-12 appear1'>
												<p class='lead'>One Stop Stove Shop</p>
												<div class='list-group'>
													<a href='index.php?category=All' class='list-group-item'>
														All Products
													</a>
													<a href='index.php?category=Wood Burning' class='list-group-item'>
														Wood Burning Stoves
													</a>
													<a href='index.php?category=Gas' class='list-group-item'>
														Gas Stoves
													</a>
													<a href='index.php?category=Multifuel' class='list-group-item'>
														Multifuel Stoves
													</a>
												</div>
											</div>";
								?>
								<div class="col-sm-12 col-md-9">  
									<div class="row">
									<?php
										echo "<div class='thumbnail'>
												<img class='img-responsive' src='assets/".$products[$pi]['picture']."' alt='".$products[$pi]['picture']."'>
												<div class='caption-full'>
													<h4 class='pull-right'>£".$products[$pi]['price']."</h4>
													<h4>".$products[$pi]['name']."</h4>
													<p>".$products[$pi]['long']."</p>
													<form action='./index.php?view_product=$pi' method='post'>
														<div class='row'>
															<span class='col-md-2 col-xs-4'>
																<select class='form-control' name='quantity'>
																	<option value='1'>1</option>
																	<option value='2'>2</option>
																	<option value='3'>3</option>
																	<option value='4'>4</option>
																	<option value='5'>5</option>
																</select>
															</span>
															<span class'col-md-2 col-xs-2'>
																<input type='hidden' name='product_id' value='$pi' />
																<input class='btn btn-default' type='submit' name='add_to_cart' value='Add to Cart' />
															</span>	
														</div>
													</form>
												</div>
												<div class='ratings'>
													<p><span class='glyphicon glyphicon-tag' style='color: #333;'></span>
													<a href='index.php?category=".$products[$pi]['category']."'>".$products[$pi]['category']."</a></p>
													<p class='pull-right'>" . $products[$pi]['reviews'] . " reviews</p>";
													if($products[$pi]['rating']==5.0){
														echo "<p>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															".$products[$pi]['rating']." Stars
														</p>";
													} else if(($products[$pi]['rating']<5)&&($products[$pi]['rating']>=4.5)){
														//Needs to be changed so it displays a half star (4.5)
														echo "<p>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star-empty'></span> 
															".$products[$pi]['rating']." Stars
														</p>";
													} else if(($products[$pi]['rating']<4.5)&&($products[$pi]['rating']>=4.0)){
														echo "<p>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star-empty'></span> 
															".$products[$pi]['rating']." Stars
														</p>";
													} else if(($products[$pi]['rating']<4.0)&&($products[$pi]['rating']>=3.5)){
														//Needs to be changed so it displays a half star (3.5)
														echo "<p>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span> 
															".$products[$pi]['rating']." Stars
														</p>";
													} else if(($products[$pi]['rating']<3.5)&&($products[$pi]['rating']>=3.0)){
														echo "<p>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span> 
															".$products[$pi]['rating']." Stars
														</p>";
													} else if(($products[$pi]['rating']<3.0)&&($products[$pi]['rating']>=2.5)){
														//Needs to be changed so it displays a half star (2.5)
														echo "<p>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span> 
															".$products[$pi]['rating']." Stars
														</p>";
													} else if(($products[$pi]['rating']<2.5)&&($products[$pi]['rating']>=2.0)){
														echo "<p>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span> 
															".$products[$pi]['rating']." Stars
														</p>";
													} else if(($products[$pi]['rating']<2.0)&&($products[$pi]['rating']>=1.5)){
														//Needs to be changed so it displays a half star (1.5)
														echo "<p>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span> 
															".$products[$pi]['rating']." Stars
														</p>";
													} else if(($products[$pi]['rating']<1.5)&&($products[$pi]['rating']>=1.0)){
														echo "<p>
															<span class='glyphicon glyphicon-star'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span> 
															".$products[$pi]['rating']." Stars
														</p>";
													} else if(($products[$pi]['rating']<1.0)&&($products[$pi]['rating']>=0.5)){
														//Needs to be changed so it displays a half star (0.5)
														echo "<p>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															".$products[$pi]['rating']." Stars
														</p>";
													} else if (($products[$pi]['rating']<0.5)&&($products[$pi]['rating']>=0.0)){
														echo "<p>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															<span class='glyphicon glyphicon-star-empty'></span>
															".$products[$pi]['rating']." Stars
														</p>";
													}
													echo "</p>
												</div>
											</div>";
											
									echo "<div class='well'>
										<div class='text-right'>";
											if($currentuser['userlevel']<2){
												echo "Please sign in to leave a review.";
											} else {
												echo "<a id='open-review-box' class='btn btn-success'>Leave a Review</a>";
											}
										echo "</div>
										<div class='row' id='post-review-box' style='display:none;'>
											<div class='col-xs-12'>
												<form action='./index.php?view_product=$pi' method='POST'>
													<div class='pull-right'>
														<fieldset class='ratings padding-top-10'>
															<input type='radio' id='star5' name='rating' value='5' /><label class='glyphicon glyphicon-star full' for='star5'></label>
															<input type='radio' id='star4' name='rating' value='4' /><label class='glyphicon glyphicon-star full' for='star4'></label>
															<input type='radio' id='star3' name='rating' value='3' /><label class='glyphicon glyphicon-star full' for='star3'></label>
															<input type='radio' id='star2' name='rating' value='2' /><label class='glyphicon glyphicon-star full' for='star2'></label>
															<input type='radio' id='star1' name='rating' value='1' /><label class='glyphicon glyphicon-star full' for='star1'></label>
														</fieldset>
													</div>	
													<textarea id='textarea' class='form-control' maxlength='80' placeholder='Enter your review here...' name='comment' cols='5' rows='5' style='overflow: hidden; word-wrap: break-word; resize: none; height: 34px;'></textarea>
													<div id='textarea_feedback'></div>
													<div class='text-right padding-top-10'>	
														<a class='btn btn-danger' id='close-review-box'><span class='glyphicon glyphicon-remove'></span> Cancel</a>
														<input type='hidden' name='product_id' value='$pi' />
														<button class='btn btn-success' type='submit' name='add_review' id='clickme'>Submit <span class='glyphicon glyphicon-menu-right'></span></button>
														</div>
												</form>	              
											</div>
										</div>
										
										<hr>";
										?>
										<?php
											$db=createConnection();
											$sql = "SELECT reviewID,reviewText,reviewTime,reviewRating,reviewPoster,productID,username,userid FROM review JOIN user ON reviewPoster = userid WHERE productID='".$pi."' ORDER BY reviewTime DESC;";

											$stmt = $db->prepare($sql);
											$stmt->execute();
											$stmt->store_result();
											$stmt->bind_result($reviewid,$reviewtext,$reviewtime,$reviewrating,$reviewposter,$productid,$username,$userid);
											
											//build review html
											while($stmt->fetch()) {
												echo "<div class='row'>
													<div class='col-md-12'>";
														if($reviewrating==5){
															echo "<p>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																".$username."
																<span class='pull-right'>".date('j M Y', strtotime($reviewtime))."</span>
															</p>";
														} else if($reviewrating>=4){
															echo "<p>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star-empty'></span> 
																".$username."
																<span class='pull-right'>".date('j M Y', strtotime($reviewtime))."</span>
															</p>";
														} else if($reviewrating>=3){
															echo "<p>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star-empty'></span>
																<span class='glyphicon glyphicon-star-empty'></span> 
																".$username."
																<span class='pull-right'>".date('j M Y', strtotime($reviewtime))."</span>
															</p>";
														} else if($reviewrating>=2){
															echo "<p>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star-empty'></span>
																<span class='glyphicon glyphicon-star-empty'></span>
																<span class='glyphicon glyphicon-star-empty'></span> 
																".$username."
																<span class='pull-right'>".date('j M Y', strtotime($reviewtime))."</span>
															</p>";
														} else if($reviewrating>=1){
															echo "<p>
																<span class='glyphicon glyphicon-star'></span>
																<span class='glyphicon glyphicon-star-empty'></span>
																<span class='glyphicon glyphicon-star-empty'></span>
																<span class='glyphicon glyphicon-star-empty'></span>
																<span class='glyphicon glyphicon-star-empty'></span> 
																".$username."
																<span class='pull-right'>".date('j M Y', strtotime($reviewtime))."</span>
															</p>";
														}
														echo "<p>".$reviewtext."</p>";
														// if user is logged in and not suspended add delete button
														if($currentuser['userlevel']>2 || ($currentuser['userid']==$userid && $currentuser['userlevel']>1)) {
															echo "<p><a class='btn btn-default' href='deletereview.php?rID=$reviewid' id='db$reviewid'>Delete Review</a></p>";
														}
													echo "</div>
												</div>
												<hr>";
											}
											$stmt->close();
											$db->close();
										?>
									</div>
									</div>
								</div>
							</div>
						</div>
				<?php
					} else {
						echo "Invalid product!";
					}
				} else if(isset($_GET['view_cart'])) { // View cart
					
					echo "<div class='container'>
							<div class='row'>";
					
					if(empty($_SESSION['shopping_cart'])) {
						echo "<div class='col-xs-12'>	
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h3 class='panel-title'>Shopping Cart</h3>
								</div>
								<div class='panel-body gbg'>
									<div class='col-sm-12'>		
										<span style='white-space:nowrap'><h4>Your shopping cart is empty.</h4></span>
										<span style='white-space:nowrap'><h4> Return to the <a href='index.php'>store</a>.</span> 
									</div>	
								</div>
							</div>					
						</div>";
					} else {
						$total_price = 0;	
						$numItems = 0;
						foreach($_SESSION['shopping_cart'] as $id => $product) {
							$product_id = $product['product_id'];
						
							$total_price += $products[$product_id]['price'] * $product['quantity'];
							$numItems += $product['quantity'];
						}	
						setlocale(LC_MONETARY, "en_GB.UTF-8");
						$total_price = money_format("%10.2n", $total_price);
						echo "<div class='row'>
								<div class='col-xs-12 appear pull-left'>	
									<div class='panel panel-default'>
										<div class='panel-heading'>
											<h3 class='panel-title'>Checkout</h3>
										</div>
										<div class='panel-body text-center gbg'>
											<div class='col-sm-12'>	
												<h4><b>Subtotal (".$numItems." Items):</b><b class='sc-color'> ".$total_price."</b></h4>	
												<div>
													<a href='#' class='btn btn-warning'>
														PayPal Checkout 
													</a>
												</div>	
												<div class='padding-top-10'>	
													<a href='index.php?empty_cart' class='btn btn-danger'>
														Empty Cart
													</a>
												</div>
											</div>	
										</div>
									</div>					
								</div>
							</div>";
						echo "<div class='row'>
								<div class='col-sm-3 col-lg-2 hidem pull-right'>	
									<div data-spy='affix'>
										<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title'>Checkout</h3>
											</div>
											<div class='panel-body text-center gbg'>
												<span style='white-space:nowrap'><h4><b>Subtotal</b></h4></span><span style='white-space:nowrap'><h4><b> (".$numItems." Items):</b></h4></span> 	
												<h4 class='sc-color'><b> ".$total_price."</b></h4>
												<div>
													<a href='#' class='btn btn-warning'>
														PayPal Checkout 
													</a>
												</div>	
												<div class='padding-top-10'>	
													<a href='index.php?empty_cart' class='btn btn-danger'>
														Empty Cart
													</a>
												</div>
											</div>
										</div>
									</div>					
								</div>
							</div>";
						echo "<div class='row hidem'>
								<div class='col-sm-9 col-lg-10'>
									<div class='panel panel-default'>
										<div class='panel-heading'>
											<h3 class='panel-title'>Shopping Cart</h3>	
										</div>
										<div class='panel-body gbg'>";
						foreach($_SESSION['shopping_cart'] as $id => $product) {
							$product_id = $product['product_id'];
							
							setlocale(LC_MONETARY, "en_GB.UTF-8");
							$products[$product_id]['price'] = money_format("%10.2n", $products[$product_id]['price']);
							
							echo "<!-- For Image/Item Info Column -->
								<div class='col-sm-7'>
									<span>
										<h5><b>Product</b></h5>
									</span>
										<div class='row'>	
											<div class='col-sm-12 padding-top-10 sc-border'>	
												<div class='row'>	
													<div class='col-sm-6 col-md-5 col-lg-4'>
														<div class='row'>
															<img class='pull-left img-responsive' src='assets/".$products[$product_id]['picture']."' alt='".$products[$product_id]['picture']."'>
														</div>
													</div>
													<div class='col-sm-6 col-md-7 col-lg-8 pull-right'>	
														<p>
															<a href='index.php?view_product=".$product_id."'>".$products[$product_id]['name']."</a> by <a href='index.php?category=".$products[$product_id]['brand']."'>".$products[$product_id]['brand']."</a>
														</p>
														<p>
															<a href='index.php?category=".$products[$product_id]['category']."'>".$products[$product_id]['category']."</a>
														</p>
														<p style='color:green;'>
															In Stock
														</p>
														<div class='checkbox hidem1'>
															<label>
																<input type='checkbox' id='giftbox' name='giftbox' /> This will be a gift <a href='#'>Learn More</a>
															</label>
														</div>
														<div class='checkbox appear1'>
															<label>
																<input type='checkbox' id='giftbox' name='giftbox' /> This is a <a href='#'>gift</a>
															</label>
														</div>
														<p>
															<form action='index.php?view_cart' method='post'>
																<input name='deleteBtn" . $product_id . "' type='submit' value='Delete' class='btn btn-danger' />
																<input name='index_to_remove' type='hidden' value='" . $product_id . "' />
															</form>
														</p>
													</div>	
												</div>	
											</div>
										</div>	
									</div>
									<!-- For Price Column -->
									<div class='col-sm-2 text-left'>
										<span>
											<h5><b>Price</b></h5>
										</span>
										<div class='row'>
											<div class='col-sm-12 padding-top-10 text-left sc-border'>
												<span class='sc-color'>
													<b>".$products[$product_id]['price']."</b>
												</span>
											</div>
										</div>
									</div>
									<!-- For Quantity Column -->
									<div class='col-sm-3 text-right'>
										<span>
											<h5><b>Quantity</b></h5>
										</span>
										<div class='row'>
											<div class='col-sm-12 padding-top-10 sc-border'>
												<form action='./index.php?view_cart' method='post'>	
													<input type='text' class='form-control input-sm' name='quantity[$product_id]' value='" . $product['quantity'] . "' size='1' />
													<p class='padding-top-10'>
														<input type='hidden' name='product_id' value='$product_id' />
														<input class='btn btn-info' type='submit' name='update_cart' value='Update' />
													</p>	
												</form>	
											</div>
										</div>
									</div>";
						}
							echo "<hr></div>
								</div>	
							</div>
						</div>";
							
						echo "<div class='row'>
								<div class='col-xs-12 appear pull-right'>
									<div class='panel panel-default'>
										<div class='panel-heading'>							
											<h3 class='panel-title'>Shopping Cart</h3>	
										</div>
									<div class='panel-body gbg'>";
						foreach($_SESSION['shopping_cart'] as $id => $product) {
							$product_id = $product['product_id'];
						
							echo "<!-- For Image/Item Info Column -->
								<div class='col-xs-12 sc-border'>
									<div class='row'>
										<div class='col-xs-12'>	
											<div class='row padding-top-10'>	
												<div class='col-xs-12'>	
													<div class='row'>
														<div class='col-xs-4'>
															<div class='row'>
																<img class='pull-left img-responsive' src='assets/".$products[$product_id]['picture']."' alt='".$products[$product_id]['picture']."'>
															</div>
														</div>
														<div class='col-xs-8 pull-right'>	
															<p>
																<a href='index.php?view_product=".$product_id."'>".$products[$product_id]['name']."</a>
															</p>
															<p class='sc-color'>
																<b>".$products[$product_id]['price']."</b>
															<p>
															<p style='color:green;'>
																In Stock
															</p>
															<div class='checkbox'>
																<label>
																	<input type='checkbox' id='giftbox' name='giftbox' /> This is a <a href='#'>gift</a>
																</label>
															</div>	
														</div>	
													</div>	
												</div>	
												<div class='col-xs-12 padding-top-10'>
													<div class='row'>
														<div class='col-xs-4'>
															<div class='row'>	
																<form action='./index.php?view_cart' method='post'>
																	<input type='text' class='form-control input-sm' name='quantity[$product_id]' value='" . $product['quantity'] . "' size='1' />
																	<p class='padding-top-10'>
																		<input type='hidden' name='product_id' value='$product_id' />
																		<input class='btn btn-info' type='submit' name='update_cart' value='Update' />
																	</p>
																</form>
															</div>	
														</div>	
													<div class='col-xs-4'>
														<form action='index.php?view_cart' method='post'>
															<input name='deleteBtn" . $product_id . "' type='submit' value='Delete' class='btn btn-danger' />
															<input name='index_to_remove' type='hidden' value='" . $product_id . "' />
														</form>
													</div>		
												</div>	
											</div>
										</div>	
									</div>	
								</div>
							</div>";
						}	
							echo "<hr></div>
								</div>
							</div>
						</div>";
					}
					echo "</div>
						</div>
					</div>";
				} else { // View all products
					echo "<div class='hidem1'>";	
						if ($c=='All'){
							echo "<div class='col-md-3'>
								<div data-spy='affix'>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item active'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
						} else if ($c=='Wood Burning'){
							echo "<div class='col-md-3'>
								<div data-spy='affix'>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item active'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
						} else if ($c=='Gas'){
							echo "<div class='col-md-3'>
								<div data-spy='affix'>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item active'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
						} else if ($c=='Multifuel'){
							echo "<div class='col-md-3'>
								<div data-spy='affix'>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item active'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
						} else {
							echo "<div class='col-md-3'>
								<div data-spy='affix'>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
					}
					echo "</div>";
					
					echo "<div class='appear1'>";	
						if ($c=='All'){
							echo "<div class='col-md-12'>
								<div>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item active'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
						} else if ($c=='Wood Burning'){
							echo "<div class='col-md-12'>
								<div>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item active'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
						} else if ($c=='Gas'){
							echo "<div class='col-md-12'>
								<div>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item active'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
						} else if ($c=='Multifuel'){
							echo "<div class='col-md-12'>
								<div>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item active'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
						} else {
							echo "<div class='col-md-12'>
								<div>
									<p class='lead'>One Stop Stove Shop</p>
									<div class='list-group'>
										<a href='index.php?category=All' class='list-group-item'>
											All Products
										</a>
										<a href='index.php?category=Wood Burning' class='list-group-item'>
											Wood Burning Stoves
										</a>
										<a href='index.php?category=Gas' class='list-group-item'>
											Gas Stoves
										</a>
										<a href='index.php?category=Multifuel' class='list-group-item'>
											Multifuel Stoves
										</a>
									</div>
								</div>
							</div>";
					}
					echo "</div>";
			?>
            <div class="col-md-9">
				<div class="row">
					<!-- Carousel -->
					<div class="row carousel-holder">
						<div class="col-md-12">
							<div id="carousel" class="carousel slide" data-ride="carousel">
								<!-- Indicators -->
								<ol class="carousel-indicators">
									<li data-target="#carousel" data-slide-to="0" class="active"></li>
									<li data-target="#carousel" data-slide-to="1"></li>
									<li data-target="#carousel" data-slide-to="2"></li>
								</ol>
								<!-- Wrapper for Slides -->
								<div class="carousel-inner">
									<div class="item active">
										<img class="slide-image" src="assets/carousel_image1.jpg" alt="One Stop Stove Shop">
									</div>
									<div class="item">
										<img class="slide-image" src="assets/carousel_image2.jpg" alt="One Stop Stove Shop">
									</div>
									<div class="item">
										<img class="slide-image" src="assets/carousel_image3.jpg" alt="One Stop Stove Shop">
									</div>
								</div>
								<!-- Left and right controls -->
								<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="right carousel-control" href="#carousel" role="button" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
							</div>
						</div>
					</div>
					<!-- Carousel End -->	
					<div class="row">
					<?php
						// Loop to display all products
						foreach($products as $id => $product) {
							echo "<div class='col-sm-4 col-lg-4 col-md-4'>
								<div class='thumbnail'>
									<img src='assets/".$product['picture']."' alt='".$product['picture']."'>
									<div class='caption'>
										<h4 class='pull-right'>£".$product['price']."</h4>
										<h4><a href='index.php?view_product=".$product['id']."'>".$product['name']."</a>
										</h4>                           
										<p>".$product['short']."</p>
									</div>
									<div class='ratings'>
										<p class='pull-right'>" . $product['reviews'] . " reviews</p>";
										if($product['rating']==5.0){
											echo "<p>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
											</p>";
										} else if(($product['rating']<5)&&($product['rating']>=4.5)){
											//Needs to be changed so it displays a half star (4.5)
											echo "<p>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star-empty'></span> 
											</p>";
										} else if(($product['rating']<4.5)&&($product['rating']>=4.0)){
											echo "<p>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star-empty'></span> 
											</p>";
										} else if(($product['rating']<4.0)&&($product['rating']>=3.5)){
											//Needs to be changed so it displays a half star (3.5)
											echo "<p>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span> 
											</p>";
										} else if(($product['rating']<3.5)&&($product['rating']>=3.0)){
											echo "<p>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span> 
											</p>";
										} else if(($product['rating']<3.0)&&($product['rating']>=2.5)){
											//Needs to be changed so it displays a half star (2.5)
											echo "<p>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span> 
											</p>";
										} else if(($product['rating']<2.5)&&($product['rating']>=2.0)){
											echo "<p>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span> 
											</p>";
										} else if(($product['rating']<2.0)&&($product['rating']>=1.5)){
											//Needs to be changed so it displays a half star (1.5)
											echo "<p>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span> 
											</p>";
										} else if(($product['rating']<1.5)&&($product['rating']>=1.0)){
											echo "<p>
												<span class='glyphicon glyphicon-star'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span> 
											</p>";
										} else if(($product['rating']<1.0)&&($product['rating']>=0.5)){
											//Needs to be changed so it displays a half star (0.5)
											echo "<p>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
											</p>";
										} else if (($product['rating']<0.5)&&($product['rating']>=0.0)){
											echo "<p>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
												<span class='glyphicon glyphicon-star-empty'></span>
											</p>";
										}
									echo "</div>
								</div>
							</div>";
						}	
					}
					?>
					</div>
				</div>	
			</div> 
		</div>
    </div> 
	<!-- End of Page Content -->
	
<?php 
	include 'includes/overall/footer.php'; 
?>	