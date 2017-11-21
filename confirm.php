<?php 
	include 'includes/overall/header.php'; 
	
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
	
	$dayob=$_POST['dayob'];
	$monthob=$_POST['monthob'];
	$yearob=$_POST['yearob'];
	$dob=$yearob."-".$monthob."-".$dayob;
	$tnc=(isset($_POST['tnc'])?1:0);
	$salt=getSalt(16);
	$cryptpass=makeHash($p,$salt,50);
	// Used to check that submitted user does not exist already
	$userexists=false;
	$emailexists=false;
	// connect to database
	$db = createConnection();
	// check form details again in case javascript disabled form bypassed
	// javascript client side scripting
	// check username and email do not already exist
	$sql="select username,emailadd from user where username=? or emailadd=?;";
	$stmt=$db->prepare($sql);
	$stmt->bind_param("ss",$un,$e);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($userresult,$emailresult);
	while($row=$stmt->fetch()) {
		if($userresult==$un) {$userexists=true;}
		if($emailresult==$e) {$emailexists=true;}
	}
	// check user is old enough
	$latestbirthday=mktime(0, 0, 0,date("m"),date("d"),date("Y")-16); // the last value controls min age
	$birthday=mktime(0, 0, 0, $monthob, $dayob, $yearob);
	$validage=(($birthday-$latestbirthday)>0?false:true);
	// Check submitted and calculated variables before storing
	if(!$userexists && !$emailexists && $p==$sp && isset($p) && $tnc && $validage && $fn && $ln && $e && $p && $s && $c && $h && $co && $un) {

	// insert new user
		$insertquery="insert into user (username, firstname, surname, emailadd, dob, usertype, tnc, housename, streetname, city, county, postcode, landline, mobile, salt, userpass) values (?,?,?,?,?,2,?,?,?,?,?,?,?,?,?,?);";
		$inst=$db->prepare($insertquery);
		$inst->bind_param("sssssisssssssss", $un, $fn, $ln, $e, $dob, $tnc, $h, $s, $c, $co, $pt, $l, $m, $salt, $cryptpass);
		$inst->execute();
	// check user inserted, if so create login form
		if($inst->affected_rows==1) {
		
?>

<body id="confirm">

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="text-center">
				<header>
					<h2>Your Registration Details</h2>
				</header>
				<h3>Welcome <?php echo $fn." ".$ln; ?></h3>
				<p> You can now login with your username <em><?php echo $un; ?></em></p>
			</div>
			<div class = "col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
				<div class="well text-center">
					<?php if($currentuser['userlevel']<1) { ?><form name="loginform" id="loginform" method="post" action="php/processlogin.php">
						<legend>Login</legend>
						<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-user"></span>
							</span>
							<input type="text" class="form-control" name="username" id="username" placeholder="Username" size="10" required />
						</div>
						<div class="input-group padding-top-10">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-lock"></span>
							</span>
							<input type="password" class="form-control" name="userpass1" id="userpass1" placeholder="Password" size="10" required />
						</div>
						<div class="checkbox text-center">
							<label><input type="checkbox" value="">Remember me</label>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>									
						</div>
						<?php } ?>
						</form>
					<?php if($currentuser['userlevel']<2) { ?>
					<div class="text-center padding-top-10">
						<a href="#"><span class="glyphicon glyphicon-question-sign"></span> Forgotten your password?</a>							
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php } else { 
		//feedback there was a problem adding the user
		echo "<div class='container'>
					<div class='row text-center'><p>There was a problem adding your details. Please contact the website administrators.</p>
					</div>
				</div>";
		}
	} else { 
	// registration failed either due to disabled javascript or other attempt to bypass validation
	?>	
	
		<div class="container">
			<div class="row">		
				<header>
					<h1>Registration Failed</h1>
				</header>
				<?php 
					if($emailexists){echo "<p>The email address $e already exists.</p>";}
					if($userexists){echo "<p>The username $un already exists.</p>";}
					if($p!=$sp){echo "<p>The passwords do not match.</p>";}
					if($un==FALSE){echo '<p>Please enter a valid username.</p>';}
					if($fn==FALSE){echo '<p>Please enter your first name.</p>';}
					if($ln==FALSE){echo '<p>Please enter your surname.</p>';}
					if($e==FALSE){echo '<p>Please enter a valid email address.</p>';}
					if($h==FALSE){echo '<p>Please enter your house name / number.</p>';}
					if($s==FALSE){echo '<p>Please enter your street address.</p>';}
					if($c==FALSE){echo '<p>Please enter a valid city.</p>';}
					if($co==FALSE){echo '<p>Please enter a valid county.</p>';}
					if($_POST['userpass']==$_POST['username']){echo '<p>Your password cannot be the same as the username.</p>';}
					if($_POST['userpass']!=$_POST['username']&&$p==FALSE){echo '<p>Please enter a valid password.</p>'; }
					if($pt==FALSE){echo '<p>Please enter a valid postcode.</p>';}
				?>		
				<p>You need to return to the <a href = "registration.php">registration</a> page and try again</p>
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