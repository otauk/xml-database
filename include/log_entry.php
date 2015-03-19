<?php
	function log_entry ($action) {
	$username = $_SESSION["intern"];
	require("../conn.php");
	$IP = getenv('REMOTE_ADDR');
	$log = 	"INSERT INTO log_db
			(username, stempel, action, IP) values (
			'$username',
			NOW(),
			'$action',
			'$IP'
			)";
	$logentry = $con->query($log);
}
?>