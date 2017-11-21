<?php 
	include 'includes/overall/header.php'; 
	
	if($currentuser['userlevel']<3) {
		header("location: index.php");
	}
	
	$UploadName = $_FILES['images']['name'];
	
	if (preg_match ('%^[A-Za-z0-9\.\' \-]{1,40}$%', stripslashes(trim($_POST['brand'])))) { 
		$b = $_POST['brand']; 
	} else { 
		$b = FALSE; 		 
	} 
	
	if (preg_match ('%^[A-Za-z0-9\.\' \-]{1,40}$%', stripslashes(trim($_POST['product_name'])))) { 
		$pn = $_POST['product_name']; 
	} else { 
		$pn = FALSE; 		 
	} 
	 
	if (preg_match ('%^[0-9\.?]{1,6}$%', stripslashes(trim($_POST['price'])))) { 
		$p = $_POST['price'];
		$p = (float)$p;
	} else { 
		$p = FALSE;		
	}
	
	$c = $_POST['category']; 
	if ($c==1){
		$c="Gas";
	} else if ($c==2){
		$c="Wood Burning";
	} else if ($c==3){
		$c="Multifuel";
	} else {
		$c=FALSE;
	}
	
	if (preg_match ('%^[A-Za-z0-9\.\' \-]{1,80}$%', stripslashes(trim($_POST['short'])))) { 
		$s = $_POST['short']; 
	} else { 
		$s = FALSE; 		 
	}
	
	if (preg_match ('%^[A-Za-z0-9\.\' \-]{1,140}$%', stripslashes(trim($_POST['long'])))) { 
		$l = $_POST['long']; 
	} else { 
		$l = FALSE; 		 
	}
	
	if (preg_match ('%^[A-Za-z0-9\.\_\-]+\.[A-Za-z]{2,5}$%', stripslashes(trim($_POST['picture'])))) { 
		$i = $_POST['picture']; 
	} else { 
		$i = FALSE; 		 
	}

	// connect to database
	$db = createConnection();
	
	// Check submitted and calculated variables before storing
	if($b && $pn && $p && $c && $s && $l && $i) {

	// insert new product
		$insertquery="INSERT INTO products (brand, productName, category, short_description, long_description, price, date_added, rating, picture) values (?, ?, ?, ?, ?, ?, now(), 0.0, ?);";
		$inst=$db->prepare($insertquery);
		$inst->bind_param("sssssds", $b, $pn, $c, $s, $l, $p, $i);
		$inst->execute();
	// check product inserted, if so create confirmation form
		if($inst->affected_rows==1) {
		
?>

<body>

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class = "col-md-6 col-md-offset-3">
				<div class="well text-center">
					<legend>Product Created</legend>
					<p> The product has succcessfull been created, and added to the store.</p>
					<div class="row padding-top-10">
						<a href="regproduct.php" type="submit" class="btn btn-success" value="Go to Create Products">
							<span class="glyphicon glyphicon-menu-left"></span> Create Another Product
						</a>
						<a href="admin.php" type="submit" class="btn btn-success" value="Go to Admin page">
							Continue <span class="glyphicon glyphicon-menu-right"></span>
						</a>	
					</div>				
				</div>
			</div>
		</div>
	</div>
	
	<?php } else { 
		//feedback there was a problem adding the user
		echo "<div class='container'>
				<div class='row text-center'><p>There was a problem adding product details. Please contact the website administrators.</p>
			</div>
		</div>";
		}
	}else { 
	// insert failed either due to disabled javascript or other attempt to bypass validation
	?>	
	
		<div class="container">
			<div class="row">		
				<header>
					<h1>Creation Failed</h1>
				</header>
				<?php 
					if($b==FALSE){echo "<p>Please enter a valid brand.</p>";}
					if($pn==FALSE){echo '<p>Please enter a valid name.</p>';}
					if($p==FALSE){echo '<p>Please enter a valid price.</p>';}
					if($c==FALSE){echo '<p>Please enter a valid category.</p>';}
					if($s==FALSE){echo '<p>Please enter a valid short description.</p>';}
					if($l==FALSE){echo '<p>Please enter a valid long description.</p>';}
					if($i==FALSE){echo '<p>Please enter a valid picture name.</p>';}
				?>		
				<p>You need to return to the <a href = "regproduct.php">create</a> page and try again</p>
			</div>
		</div>
	<?php 
	}
	$stmt->close();
	$inst->close();
	$db->close(); 
	?>
	<!-- End of Page Content -->
	
<?php 
	include 'includes/overall/footer.php'; 
?>