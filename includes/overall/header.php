<?php
//setCookie("userintent","",(time+86400),"/OneStopStoveShop/");
session_start();
include('php/functions.php');
$currentuser=getUserLevel();
?>
<!DOCTYPE html>
<html lang = "en">
	<?php include 'includes/head.php'; ?>