<?php session_start();
include ("../bin/login_func.php");
loggedInUser();
include("../header_login.php");
include("../../conn.php");
/* ^^^^^ ID des eingeloggten Users aus db auslesen ^^^^^ */
$query = "SELECT * FROM user_db WHERE name LIKE '$username'";
$result = $con->query($query);
$user = mysqli_fetch_assoc($result);
// User ID wird zu $id für alle späteren Auswertungen
$id = $user["ID"];
// Daten einsammeln
$password = $_POST["passwort"];
$password2 = $_POST["passwort2"];
$check = $_POST["check"];
$confirmation = "";

// Formular gesendet?
if ($check == 1) {
	// Felder ausgefüllt?
	if (empty($password) OR empty($password2)) {
		$confirmation = "<div class='alert red'>Bitte vergeben Sie ein Passwort</div>";
		}
	// Sind die Passwörter gleich?
	else if ($password != $password2) {
		$confirmation = "<div class='alert red'>Passwörter stimmen nicht überein</div>";
	}
	// Wenn ja, Daten eintragen
	else {
		$pw_update = "UPDATE user_db SET pw = md5('$password') WHERE ID = $id";
		$eintragen = mysqli_query($con,$pw_update);
		if($eintragen == true) {
			// Ausgabe der Bestätigung
			$confirmation = "<div class='alert green'>Neues Passwort gesetzt</div>";
		}
	}
}
?>
<div id="main_login">
	<div id="content">
		<div class="heading">Passwort ändern für <?php echo $username; ?></div>
			<?php echo $confirmation;?>
		<!-- Ausgabe der Bestätigung -->
		<form name='password_update' action='pw_change.php' method='post'>
		<input type="hidden" name="check" value="1" />
			<div class='fieldname'>Neues Passwort:</div>
				<input type='password' size='50' maxlength='50' name='passwort'  class='textfield' required='required' id="passwort">
				<div class='fieldname'>Neues Passwort wiederholen:</div>
				<input type='password' size='50' maxlength='50' name='passwort2'  class='textfield' required='required' id="passwort2">
				<div class="topspace">
					<span><input type="checkbox" id="plain_check" onClick="plain()" ></span>
					Klartext
				</div>
			<div class='topspace'>
			 <a  class='form_btn password' onClick='password_update.submit();'>
				&nbsp; Passwort setzen
			</a>

			<a class='form_btn reset' onClick='javascript:document.password_update.reset();'>
				&nbsp; Formular löschen
			</a>
			</div>
			<hr>
			<div>
				<a href='../../index.php' class='form_btn back'> Zum Login</a>
			</div>
		</form>
	</div>
</div>