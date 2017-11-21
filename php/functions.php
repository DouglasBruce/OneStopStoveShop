<?php
date_default_timezone_set('Europe/London');
function createConnection() {
	$host="comp-hons.uhi.ac.uk";
	$user="pe13007173";
	$userpass='13007173';
	$schema="pe13007173";
	$conn = new mysqli($host,$user,$userpass,$schema);
	if(mysqli_connect_errno()) {
		echo "Could not connect to database: ".mysqli_connect_errno();
		exit;
	}
	return $conn;
}

function getChar($chartoget) {
	$charstr="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	return $charstr[$chartoget];
}

function getSalt($saltLength) {
	$randomString="";
	for($i=0;$i<$saltLength;$i++) {
		$randomChar=getChar(mt_rand(0,51));
		$randomString.=$randomChar;
	}
return $randomString;
}

function makeHash($plainText,$salt,$n) {
	$hash=$plainText.$salt;
	for($i=0;$i<$n;$i++) {
		$hash=hash("sha256",$plainText.$hash.$salt);
	}
	return $hash;
}

//Params passed in

//$usersessionid = user's id, $sessionid=session_id()

//$ptype = level of access required for current page 1,2 or 3

function checkUser($usersessionid,$sessionid,$ptype) {

	$dbchk = createConnection();
	$lookupsql="select usertype,sessionid,username from user where userid=?";
	$lookup=$dbchk->prepare($lookupsql);
	$lookup->bind_param("i",$usersessionid);
	$lookup->execute();
	$lookup->store_result();
	$lookup->bind_result($utype,$storedsession,$uname);
	$lookup->fetch();
	
	if($lookup->num_rows==1) {
		$lookup->close();
		$dbchk->close();
		
		if($sessionid!=$storedsession || $storedsession=="" || $utype<$ptype) {		
			header("location: php/logout.php");
			exit;
		}
	} else {
		$lookup->close();
		$dbchk->close();
		header("location: php/logout.php");
		exit;
	}
	return $uname;
}
function getUserLevel() {
	$utype=0;
	$uname="Anonymous";
	if($_SESSION['userid']!=null) {
		$sessionid=session_id();
		$usersessionid=$_SESSION['userid'];
		$dbchk = createConnection();
		$lookupsql="select usertype,sessionid,username from user where userid=?";
		$lookup=$dbchk->prepare($lookupsql);
		$lookup->bind_param("i",$usersessionid);
		$lookup->execute();
		$lookup->store_result();
		$lookup->bind_result($utype,$storedsession,$uname);
		$lookup->fetch();
		
		if($lookup->num_rows!=1 || $sessionid!=$storedsession || $storedsession=="") {
			$uname="Anonymous";
			$utype=0;
			$_SESSION['userid']="";
			$usersessionid=-1;
		}
		$lookup->close();
		$dbchk->close();		
	}
	// Here is the associative or keyed array that is sent back to the original
	// page indicating the current users access rights
	$userinfo= Array(
		'userlevel' =>	$utype,
		'username'	=>	$uname,
		'userid'	=>	$usersessionid
	);
	return $userinfo;
}
?>