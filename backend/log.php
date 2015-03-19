<?php session_start();
include ("../login/bin/login_func.php");
loggedInAdmin();
include("header_backend.php");

function log_output () {
global $con;
$sql = "SELECT * FROM log_db ORDER BY stempel DESC";
$result = $con->query($sql);
echo "<table class='tbl tablesorter' id='logTable'>";
echo "<thead><tr><th>Benutzer</th><th>Datum // Uhrzeit</th><th>Aktion</th><th>IP-Adresse</th></tr></thead>";
	while ($row = $result->fetch_object()) {
	$username = $row->username;
	$stempel = $row->stempel;
	$time = strtotime($stempel);
	$stempel_form = date("d.m.Y // G:i", $time)." Uhr";
	$action = $row->action;
	$IP = $row->IP;
	echo "<tr>";
	echo "<td>$username</td>";
	echo "<td>$stempel_form</td>";
	echo "<td>$action</td>";
	echo "<td>$IP</td>";
	echo "</tr>";
	}
echo "</table>";
$con->close;
}
?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>Protokoll</h1>
					<div>
						<?php log_output();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
$(document).ready(function() {
	$("#logTable").tablesorter({ sortList:[5,0] });
});
</script>
</body>
</html>