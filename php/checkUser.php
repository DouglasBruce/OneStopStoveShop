<?php
// identifies whether or not the username or email have previously been
// used and returns the result
include("functions.php");
$username=$_POST["username"];
$email=$_POST['email'];
$userexists=0;
$emailexists=0;
$db = createConnection();
$sql = "select username,emailadd from user where username=? or emailadd=?;";
$stmt = $db->prepare($sql);
$stmt->bind_param("ss",$username,$email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userresult,$emailresult);
while($row=$stmt->fetch()) {
	if($userresult==$username) {$userexists=1;}
	if($emailresult==$email) {$emailexists=1;}
}
$json[]=array (
	'userexists' => $userexists,
	'emailexists' => $emailexists
	);
echo json_encode($json);
$stmt->close();
$db->close();
?>
