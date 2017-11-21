<?php
session_start();
include("functions.php");
//The ampersand is used to assign a 'null' value if 
//there is currently no userid session variable set
$userid=&$_SESSION['userid'];
$sessionid=session_id();
if(!is_null($userid)) {
	//To prevent hack attempts from logging people out with
	//legitimate logins both userid and session id must match
	//before it clears the sessionid
	$clearquery="update user set sessionid='' where userid=? and sessionid=?";
	$db=createConnection();
	$doclear=$db->prepare($clearquery);
	$doclear->bind_param("is",$userid,$sessionid);
	$doclear->execute();
	$doclear->close();
	$db->close();
}
// Unset the session variables then destroy the current session
session_unset();
session_destroy();
header("location: ../index.php");
?>
