<?php
include("../conn.php");
// Kunden-DB für kunden_id
$abfrage = "SELECT * FROM user_db WHERE name =  '$username' LIMIT 1";
$erg = $con->query($abfrage);
$row = mysqli_fetch_object($erg);

if ($row->group == 1) {
?>
<a href="#">
	<div class="user_dropdown form_btn user" data-dropdown="#dropdown-1">
		<?=$username;?>
	</div>
</a>
<div id="dropdown-1" class="dropdown dropdown-tip">
	<ul class="dropdown-menu">
		<li>
			<a href="verwaltung.php" class="edit">zur Verwaltung</a>
		</li>
		<li class="dropdown-divider"></li>
		<li>
			<a href="../login/tools/pw_change.php" class="password">Passwort ändern</a>
		</li>
		<li>
			<a href="mailto:manuel.buczka@rub.de?subject=Störung%20XML-Datenbank%20Dentalglobal%20GmbH"  class="problem">Problem melden</a>
		</li>
		<li class="dropdown-divider"></li>
		<li>
			 <a href="../login/logout.php" class="logout">Logout</a>
		</li>
	</ul>
</div>
<?php
	}
	else {
?>
<a href="#">
	<div class="user_dropdown form_btn user" data-dropdown="#dropdown-1">
		<?=$username;?>
	</div>
</a>
<div id="dropdown-1" class="dropdown dropdown-tip">
	<ul class="dropdown-menu">
		<li>
			<a href="mailto:info@dentalglobal.de?subject=Störung%20XML-Datenbank%20Dentalglobal%20GmbH"  class="problem">Problem melden</a>
		</li>
		<li class="dropdown-divider"></li>
		<li>
			 <a href="../login/logout.php" class="logout">Logout</a>
		</li>
	</ul>
</div>

<?php
	}
?>
