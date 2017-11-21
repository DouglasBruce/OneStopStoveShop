<?php 
	session_start();
	include("functions.php");
	$username=checkUser($_SESSION['userid'],session_id(),2);
	$currentuser=getUserLevel();
	$review=$_POST['reviewid'];
	$product_id = $_POST['product_id'];
	if(!$review) { 
		header("location: ../index.php"); 
	}

	$db=createConnection();
	$sql = "SELECT reviewID,userid FROM review JOIN user ON reviewPoster = userid WHERE reviewID=?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param("i",$review);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($reviewid,$userid);
	if($stmt->num_rows==1) {
		$stmt->fetch();
		if($currentuser['userlevel']>2 || ($currentuser['userid']==$userid && $currentuser['userlevel']>1)) {
			$deletesql="DELETE FROM review WHERE reviewID=?;";
			$deletestmt=$db->prepare($deletesql);
			$deletestmt->bind_param("i",$review);
			$deletestmt->execute();
			
			$numReviews = 0;
			$sql = "SELECT numOfReviews FROM products WHERE productID='$product_id';";

			$stmt = $db->prepare($sql);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($numReviews);
			$stmt->fetch();
			
			$newNumReviews = $numReviews - 1;
			
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
		}
		
	}
	$stmt->close();
	$deletestmt->close();
	$update->close();
	$db->close();
	header("location: ../index.php?view_product=$product_id");
?>	