<?php
include 'includes/overall/header.php'; 
	
if($currentuser['userlevel']<3) {
	header("location: index.php");
}
if(isset($_POST['productid']) && isset($_POST['brand']) && isset($_POST['product_name']) && isset($_POST['price']) && isset($_POST['category']) && isset($_POST['short']) && isset($_POST['long']) ) {
	$db=createConnection();
	$pi=$_POST['productid'];
	$userdetailssql = "SELECT category FROM products WHERE productID=?;";
	$userdetails = $db->prepare($userdetailssql);
	$userdetails->bind_param("i",$pi);
	$userdetails->execute();
	$userdetails->store_result();
	$userdetails->bind_result($cd);
	if($userdetails->num_rows==1) {
			$userdetails->fetch();
	} else {
		echo "<div class='container'>
			<div class='row text-center'><p>No product found!</p>
			</div>
			</div>";
	}		
	
	
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
		$c=$cd;
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
	
	if($b && $pn && $p && $s && $l && $i){
		$updatesql="update products set brand=?,productName=?,category=?,price=?,short_description=?,long_description=?, picture=? where productID=?";
		$doupdate=$db->prepare($updatesql);
		$doupdate->bind_param("sssdsssi",$b,$pn,$c,$p,$s,$l,$i,$pi);
		$doupdate->execute();
		if($doupdate->affected_rows==0) {
			?>	
				<div class="container">
					<div class="row">		
						<header>
							<h1>Edit Failed</h1>
						</header>	
						<p>No changes were made. Return to the <a href = 'productlist.php'>Product List</a> page and try again</p>
					</div>
				</div>
			<?php 
		} else if($doupdate->affected_rows==1) {
			
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
				<legend>Success</legend>
				<p>Product was succesfully updated</p>
					<div class="row padding-top-10">					
						<form action="admin.php">
							<button type="submit" class="btn btn-success" value="Go to Admin page">
								Continue <span class="glyphicon glyphicon-menu-right"></span>
							</button>
						</form>		
					</div>	
				</div>
			</div>
		</div>
	</div>
	<!-- End of Page Content -->
	<?php } else { 
		//feedback there was a problem adding the user
		echo "<div class='container'>
				<div class='row text-center'><p>There was a problem updating product details. Please contact the website administrators.</p>
			</div>
		</div>";
		}	
	}else{
		?>	
		<div class="container">
			<div class="row">		
				<header>
					<h1>Edit Failed</h1>
				</header>
				<?php 
					if($b==FALSE){echo "<p>Please enter a valid brand.</p>";}
					if($pn==FALSE){echo '<p>Please enter a valid name.</p>';}
					if($p==FALSE){echo '<p>Please enter a valid price.</p>';}
					if($s==FALSE){echo '<p>Please enter a valid short description.</p>';}
					if($l==FALSE){echo '<p>Please enter a valid long description.</p>';}
					if($i==FALSE){echo '<p>Please enter a valid picture name.</p>';}
				?>		
				<p>You need to return to the <a href = "productlist.php">Product List</a> page and try again</p>
			</div>
		</div>
	<?php
	}
} else {
	echo "<div class='container'>
			<div class='row text-center'><p>Some parameters are missing, cannot update database!</p>
			</div>
		</div>";
}
$stmt->close();
$doupdate->close();
$db->close();
include 'includes/overall/footer.php'; 
?>