<!DOCTYPE html>
<!-- ~~~~~~~~~~~~~~~~~~~~| HEADER |~~~~~~~~~~~~~~~~~~~~ -->
<?php
$username = $_SESSION["intern"];
include("../conn.php");
$abfrage = "SELECT * FROM log_db WHERE username =  '$username' AND action = 'Login' ORDER BY stempel DESC LIMIT 1";
$erg = $con->query($abfrage);
$row = mysqli_fetch_object($erg);
$stempel = $row->stempel;
$time = strtotime($stempel);
$stempel_form = date("d.m.Y // G:i", $time)." Uhr";
?>
<html>
<head>
<title>XML-Datenbank Dentalglobal GmbH</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="author" content="Dentalglobal GmbH" />
<meta name="revisit-after" content="1 days" />
<meta name="robots" content="index, follow"/>
<?php include("../include/sources_backend.php");?>
</head>
<body>
<div id="wrapper">
<!-- ########## TOP-NAVIGATION ########## -->
	<div id="top_login">
		<div id="logo_login">
			<i class='fa fa-database'></i>&nbsp;XML-Datenbank Dentalglobal GmbH
			<span style="text-align: right;">(Letzter Login: <?=$stempel_form;?>)</span>
		</div>
			<?php include("user_dropdown.php"); ?>

	</div>
