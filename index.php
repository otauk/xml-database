<?php session_start();
// db-Verbindung herstellen
include("conn.php");
// Variablen aus Formular zuweisen
$username = $_POST["username"];
$passwort = md5($_POST["password"]);
$confirmation = "";

	/* ^^^^^ Daten aus pb_db___user_db auslesen  */
	$abfrage = "SELECT * FROM user_db WHERE name = '$username' LIMIT 1";
	$ergebnis = $con->query($abfrage);
	$row = mysqli_fetch_object($ergebnis);
	$gruppe = $row->group;
	// Username und/oder Passwort vorhanden?
		if(empty($username) OR empty($passwort)) {
			$fehler = "Bitte alle Felder ausf&uuml;llen";
			}
		else if ($row->name != $username OR $row->pw !=$passwort) {$fehler = "Username nicht vorhanden / Passwort falsch";}
		// Wenn ja...
			if (isset($username)) {
				if($row->pw == $passwort)
					{
					// Ausgabe der Weiterleitung
					if ($row->group == '1') { 				// --- Gruppe 1 = ADMIN/Mitarbeiter
					$_SESSION["admin"] = $username;
					$_SESSION["intern"] = $username;
					 header ("LOCATION: backend/verwaltung.php");
						$confirmation = "
						<div class='alert green'>Login f&uuml;r die Gruppe <strong>Mitarbeiter</strong> erfolgreich.</div>
						";
						}
					if ($row->group == '0') {				 // --- Gruppe 0 = KUNDEN
					$_SESSION["intern"] = $username;
					 header ("LOCATION: backend/kundenportal.php");
						$confirmation = "
						<div class='alert green'>Login f&uuml;r die Gruppe <strong>Kunden</strong> erfolgreich.</div>
						";
						}
					// update last login für Ausgabe in user-Ansicht
					$lastlogin = "UPDATE user_db SET last_login=NOW() WHERE name = '$username'";
					$ll = $con->query($lastlogin);

					// Eintrag in log_db

							$IP = getenv('REMOTE_ADDR');
							$log = 	"INSERT INTO log_db
									(username, stempel, action, IP) values (
									'$username',
									NOW(),
									'Login',
									'$IP'
									)";
							$logentry = $con->query($log);
					}
			// Wenn nicht...
				else
					{
					// Ausgabe Fehlermeldung
					$confirmation = "<div class='alert red'>$fehler</div>";
					}
			}
include("login/header_login.php");
?>

<div id="main_login">
	<div id="content">
		 <?php echo $confirmation; ?>
		<form action="index.php" name='login' method="post">
			<div class="fieldname">Dein Benutzername:</div>
			<input type="text" size="50" maxlength="50"
			name="username" class='textfield' required="required">
			<div class="fieldname">Dein Passwort:</div>
			<input type="password" size="50" maxlength="50"
			name="password" class='textfield' required="required">
			<div class='topspace'>
			<button type="submit" class="form_btn login"/> Login
			</div>
		</form>
			<br>
		<p class='smaller rightside'>Passwort <a href="login/tools/lost.php">vergessen</a>?</p>
	</div>
</div>
</div>
</body>
</html>