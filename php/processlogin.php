<?php
session_start();
session_regenerate_id();
?>
<!doctype html>
<html lang="en-gb" dir="ltr">
<head>
</head>
<body>
<?php
include('functions.php');
//Check that both a user name and user password have been set
if(isset($_POST['username']) && isset($_POST['userpass1'])){ 
	$db=createConnection();
	//Assign POSTed values to variables
	if (preg_match ('%\A(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[a-z])\S{5,25}\z%', stripslashes(trim($_POST['username'])))) { 
		$un = $_POST['username']; 
	} else {
		$un = FALSE;
	}
	if (preg_match ('%\A(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[a-z])(?=[-_a-zA-Z0-9]*?[0-9])\S{8,25}\z%', stripslashes(trim($_POST['userpass1'])))) { 
		$p = $_POST['userpass1']; 
	} else { 
		$p = FALSE; 
	}
	if($un && $p){
		//Create query, note that parameters being passed in are represented by question marks
		$loginsql="select userid, userpass, salt, firstname, surname, usertype from user where username=?";
		$lgnstmt = $db->prepare($loginsql);
		//Bound parameters are defined by type, s = string, i = integer, d = double and b = blob
		$lgnstmt->bind_param("s",$un);
		//Run query
		$lgnstmt->execute();
		//Store Query Result
		$lgnstmt->store_result();
		//Bind returned row parameters in same order as they appear in query
		$lgnstmt->bind_result($userid,$hash,$salt,$firstname,$surname,$usertype);
		//Valid login only if exactly one row returned, otherwise something iffy is going on
		if($lgnstmt->num_rows==1) {
			//Fetch the next (it should be only) row from the returned results
			$lgnstmt->fetch();
			$cyphertext=makeHash($p,$salt,50);
			$lgnstmt->close();
			if($cyphertext==$hash) {
				//Update user's record with session data
				$sessionsql="update user set sessionid=? where userid=?";
				$sessionstmt=$db->prepare($sessionsql);
				$sessionstmt->bind_param("si",session_id(),$userid);
				$sessionstmt->execute();
				$sessionstmt->close();
				// Store logged in userid as session variable
				$_SESSION['userid']=$userid;
				if($usertype>0 ) {
					if(!isset($_COOKIE["userintent"]) || $_COOKIE["userintent"]=="none") {
						header("location: ../account.php");
					}
					if($usertype == 1) {
						header("location: ../inactive.php");
					}
					if($usertype == 3) {
						header("location: ../admin.php");
					}
				} else {
					header("location: logout.php");
				}

			} else {
			header("location: ../login.php");
			}
		} else {
			header("location: ../login.php");
		}
		$db->close();	
	}else {
		header("location: ../login.php");
	}
} else {
	header("location: ../login.php");
}
?>
</body>
</html>
