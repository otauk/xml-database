<!DOCTYPE html>
<!-- ~~~~~~~~~~~~~~~~~~~~| HEADER |~~~~~~~~~~~~~~~~~~~~ -->
<?php
$username = $_SESSION["intern"];
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
		</div>
			<?php include("user_dropdown.php");?>
	</div>
