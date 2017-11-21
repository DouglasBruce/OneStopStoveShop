<?php
include 'includes/overall/header.php'; 
	
if($currentuser['userlevel']<3) {
	header("location: index.php");
}
if(isset($_POST['userid']) && isset($_POST['usertype']) && isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['surname']) && isset($_POST['dob']) && isset($_POST['housename']) && isset($_POST['streetname']) && isset($_POST['city']) && isset($_POST['county']) && isset($_POST['postcode']) && isset($_POST['landline']) && isset($_POST['mobile']) && isset($_POST['emailadd'])) {
	$db=createConnection();
	
	if (preg_match ('%\A(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[a-z])\S{5,25}\z%', stripslashes(trim($_POST['username'])))) { 
		$un = $_POST['username']; 
	} else {
		$un = FALSE; 
	}
	
	if (preg_match ('%^[A-Za-z\.\' \-]{2,30}$%', stripslashes(trim($_POST['firstname'])))) { 
		$fn = $_POST['firstname']; 
	} else { 
		$fn = FALSE; 		
	}
	
	if (preg_match ('%^[A-Za-z\.\' \-]{2,30}$%', stripslashes(trim($_POST['surname'])))) { 
		$ln = $_POST['surname']; 
	} else {
		$ln = FALSE;	
	} 
	
	if (preg_match ('%^[A-Za-z0-9._\-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,5}$%', stripslashes(trim($_POST['emailadd'])))) { 
		$e = $_POST['emailadd']; 
	} else { 	
		$e = FALSE; 		
	}
	
	if (preg_match ('%^[A-Za-z0-9\.\' \-]{1,40}$%', stripslashes(trim($_POST['housename'])))) { 
		$h = $_POST['housename']; 
	} else { 
		$h = FALSE; 		 
	} 
	
	if (preg_match ('%^[A-Za-z0-9\.\' \-]{5,40}$%', stripslashes(trim($_POST['streetname'])))) { 
		$s = $_POST['streetname']; 
	} else { 
		$s = FALSE; 		 
	} 
	
	if (preg_match ('%^[A-Za-z\.\' \-]{2,30}$%', stripslashes(trim($_POST['city'])))) { 
		$c = $_POST['city']; 
	} else { 
		$c = FALSE; 		
	}
	
	if (preg_match ('%^[A-Za-z\.\' \-\&]{2,30}$%', stripslashes(trim($_POST['county'])))) { 
		$co = $_POST['county']; 
	} else { 
		$co = FALSE; 		
	}
	
	if (preg_match ('%\A(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[a-z])(?=[-_a-zA-Z0-9]*?[0-9])\S{8,25}\z%', stripslashes(trim($_POST['userpass'])))) { 
		if (($_POST['userpass'] == $_POST['secondpass']) && ($_POST['userpass'] != $_POST['username'])) { 
			$p = $_POST['userpass']; 
		} elseif ($_POST['userpass'] == $_POST['username']) { 
			$p = FALSE;	
		} else { 
			$p = FALSE; 
		} 
	} else { 
		$p = FALSE;		
	}
	
	if (preg_match ('%\A(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[a-z])(?=[-_a-zA-Z0-9]*?[0-9])\S{8,25}\z%', stripslashes(trim($_POST['secondpass'])))) { 
		if (($_POST['secondpass'] == $_POST['userpass']) && ($_POST['secondpass'] != $_POST['username'])) { 
			$sp = $_POST['secondpass']; 
		} elseif ($_POST['secondpass'] == $_POST['username']) { 
			$sp = FALSE;
		} else { 
			$sp = FALSE; 
		} 
	} else { 
		$sp = FALSE;
	}
	
	if (preg_match ('%^[1-3]{1}$%', stripslashes(trim($_POST['usertype'])))) { 
		$ut = $_POST['usertype']; 
	} else { 
		$ut = FALSE; 		
	}
	
	if (preg_match ('%^[A-Za-z0-9\s?]{4,9}$%', stripslashes(trim($_POST['postcode'])))) { 
		$pt = $_POST['postcode']; 
	} else { 
		$pt = FALSE; 		
	}
	
	if (preg_match ('%^[0-9\s?]{5,14}$%', stripslashes(trim($_POST['landline'])))) { 
		$l = $_POST['landline']; 
	} else { 
		$l = FALSE;		
	}
	
	if (preg_match ('%^[0-9\+?\s?]{5,14}$%', stripslashes(trim($_POST['mobile'])))) { 
		$m = $_POST['mobile']; 
	} else { 
		$m = FALSE;	
	}
	
	if ($l==FALSE){
		$l = "n/a";
	}
	
	if ($m==FALSE){
		$m = "n/a";
	}
	
	$userid=$_POST['userid'];
	$dob=$_POST['dob'];
	if($fn && $ln && $e && $s && $c && $h && $co && $un && $ut){
		$updatesql="update user set usertype=?,username=?,firstname=?,surname=?,dob=?,housename=?,streetname=?,city=?,county=?,postcode=?,landline=?,mobile=?,emailadd=? where userid=?";
		$doupdate=$db->prepare($updatesql);
		$doupdate->bind_param("issssssssssssi",$ut,$un,$fn,$ln,$dob,$h,$s,$c,$co,$pt,$l,$m,$e,$userid);
		$doupdate->execute();
		if(isset($_POST['userpass']) && trim($_POST['userpass'])!="") {
			$plaintext=$_POST['userpass'];
			//The following generates a salt which is 16 characters in length
			$salt=getSalt(16);
			//The following generates a hash using the plain text password, the salt and a work factor of 50
			$hash=makeHash($plaintext,$salt,50);
			//Now that salt and hash are generated they need stored to the table
			$updatepasssql="update user set userpass=?,salt=? where userid=?";
			$updatepass=$db->prepare($updatepasssql);
			$updatepass->bind_param("ssi",$hash,$salt,$userid);
			$updatepass->execute();
			$updatepass->close();
		}
		if($doupdate->affected_rows==0) {
			?>	
				<div class="container">
					<div class="row">		
						<header>
							<h1>Edit Failed</h1>
						</header>	
						<p>No changes were made. Return to the <a href = 'stafflist.php'>Staff List</a> page and try again</p>
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
				<p>Account Details were Successfully Updated</p>
					<div class="row padding-top-10">					
						<form action="admin.php">
							<button type="submit" class="btn btn-success" value="Go to Manage Users">
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
				<div class='row text-center'><p>There was a problem updating user details. Please contact the website administrators.</p>
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
					if($un==FALSE){echo '<p>Please enter a valid username.</p>';}
					if($fn==FALSE){echo '<p>Please enter your first name.</p>';}
					if($ln==FALSE){echo '<p>Please enter your surname.</p>';}
					if($e==FALSE){echo '<p>Please enter a valid email address.</p>';}
					if($h==FALSE){echo '<p>Please enter your house name / number.</p>';}
					if($s==FALSE){echo '<p>Please enter your street address.</p>';}
					if($c==FALSE){echo '<p>Please enter a valid city.</p>';}
					if($co==FALSE){echo '<p>Please enter a valid county.</p>';}
					if($pt==FALSE){echo '<p>Please enter a valid postcode.</p>';}
					if($ut==FALSE){echo '<p>Please enter a valid user type.</p>';}
				?>		
				<p>You need to return to the <a href = "stafflist.php">Staff List</a> page and try again</p>
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