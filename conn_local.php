<?php
$user = 'root';
$password = 'root';
$db = 'xml';
$host = 'localhost';
$port = 8889;

$link = mysqli_init();
$success = mysqli_real_connect(
   $link,
   $host,
   $user,
   $password,
   $db,
   $port
);
/*
		$con = mysqli_connect("$host:$port",$user, $password);
	//$con = mysqli_connect('localhost','d01c63c9','AFnPqDrvAFzMPYX7','d01c63c9');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
*/
// utf-8 erzwingen wegen umlauten
$utf = "SET NAMES 'utf8'";
$utf_query=$con->query($utf);
?>